#!C:/Users/Administrator/anaconda3/python.exe
import sys
import json
import ast

#import library
import pandas as pd
import numpy as np

# #dibaca oleh laravel 
import sys
import json

# #untuk preprocessing
import nltk 
from nltk.tokenize import word_tokenize #tokenezing
from nltk.corpus import stopwords #stopwords
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory #stemming
import re #cleaning

# #Untuk Tf-IDF
from sklearn.feature_extraction.text import TfidfVectorizer

# #untuk cosine similarity
from sklearn.metrics.pairwise import cosine_similarity

nltk.download('stopwords', quiet=True)

#==================================================

def preprocess_text(text):
    # Lowercasing
    lowercased_text = text.lower()

    # Cleaning
    cleaned_text = re.sub(r'[^\w\s]', '', lowercased_text)

    # Tokenization
    tokenized_text = word_tokenize(cleaned_text)

    # Stemming
    factory = StemmerFactory()
    stemmer = factory.create_stemmer()
    stemmed_text = [stemmer.stem(word) for word in tokenized_text]

    # Unique Words
    unique_words = list(set(stemmed_text))

    # Stop Words
    stopwords_indonesia = set(stopwords.words('indonesian'))
    stopwords_removed = [word for word in unique_words if word not in stopwords_indonesia]

    # Create DataFrame
    df = pd.DataFrame({
        'title'         : [text],
        'lowercasing'   : [lowercased_text],
        'cleaning'      : [cleaned_text],
        'tokenization'  : [tokenized_text],
        'stemming'      : [stemmed_text],
        'unique_words'  : [unique_words],
        'stop_words'    : [stopwords_removed]
    })

    return df
    
#==================================================

def preprocess_tfidf_cosim(corpus):  
        
    def preprocessing(corpus):
        # Create DataFrames kosong
        df = pd.DataFrame(columns=['name', 'nim', 'year', 'title'])

        #preprocessing dan memasukkan kedalam df
        for item in corpus:
            # Extract informasi dari corpus
            name = item[0]
            nim  = item[1]
            year = item[2]
            text = item[3]

            # print(len(text))
            # Preprocessing
            result_df = preprocess_text(text)

            # masukkan value item ke dalam kolom
            result_df['name'] = name
            result_df['nim']  = nim
            result_df['year'] = year
            
            # satukan hasil preprocessing ke DataFrame utama sesuai dengan nama
            df = pd.concat([df, result_df], ignore_index=True)
        return df
    
    def tfidf(corpus):
        #paggil hasil preprocessing
        df = preprocessing(corpus)
        
        #membuat kolom baru dengan header kosong dan join setelah stopwords, memasukkan nilai bobot disetiap header yg kosong
        vectorizer = TfidfVectorizer()
        tfidf_matrix = vectorizer.fit_transform(df['stop_words'].apply(' '.join))
        
        #ambil kata dari array stopwords untuk di jadikan header
        feature_names = vectorizer.get_feature_names_out()
        
        #satukan judul header dan bobotnya
        df_tfidf = pd.DataFrame(tfidf_matrix.toarray(), columns=feature_names)
        df_tfidf = pd.concat([df, df_tfidf], axis=1)
        
        return df_tfidf
    
    def cosineSimilarity(corpus):
        df_tfidf = tfidf(corpus)
        
        # Mengambil vektor TF-IDF untuk item pertama (index 0)
        vector1 = df_tfidf.iloc[0, 10:].values.reshape(1, -1)

        # Mengambil vektor TF-IDF untuk semua item kecuali item pertama
        #vectors = tfidf_df.iloc[1:, 10:].values
        vectors = df_tfidf.iloc[:, 10:].values

        # Menghitung cosine similarity antara item pertama dan semua item lainnya
        cosim = cosine_similarity(vector1, vectors)
        
        cosim = pd.DataFrame(cosim)
        # Mengubah DataFrame menjadi array satu dimensi
        cosim = cosim.values.flatten()

        # Mengubah hasil cosine similarity menjadi DataFrame
        df_cosim = pd.DataFrame(cosim, columns=['cosim'])

        #menghitung persenan
        df_cosim['percent'] = df_cosim['cosim'] * 100
        
        # Menggabungkan array TF-IDF dengan hasil cosine similarity
        df_cosim = pd.concat([df_tfidf, df_cosim], axis=1)

        return df_cosim
    
    return cosineSimilarity(corpus)

#=================================================

def cosim(corpus):
    corpus = json.loads(corpus)

    name    = corpus['name']
    nim     = corpus['nim']
    year    = corpus['year']
    title   = corpus['title']

    corpus_combined = list(zip(name, nim, year, title))

    cosim = preprocess_tfidf_cosim(corpus_combined)
    cosim = cosim.reset_index(drop=True)
    data_json = cosim.to_json(orient='records')
    cosim = json.dumps(data_json)
    return cosim

print(cosim(sys.argv[1]))