#!/usr/bin/env python
# coding: utf-8

# In[ ]:


#!C:/Users/Administrator/anaconda3/python.exe
import sys
import json

#import library
import pandas as pd
import numpy as np

#dibaca oleh laravel 
import sys
import json

#untuk preprocessing
import nltk 
from nltk.tokenize import word_tokenize #tokenezing
from nltk.corpus import stopwords #stopwords
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory #stemming
import re #cleaning

#Untuk Tf-IDF
from sklearn.feature_extraction.text import TfidfVectorizer

#untuk cosine similarity
from sklearn.metrics.pairwise import cosine_similarity

nltk.download('stopwords', quiet=True)

#=================================================

similarity = sys.argv[1]

# corpus = '{"name":["data uji","Miftahul Ulyana Hutabarat","Developer","Developer","Developerr","Developer","Miftahul Ulyana Hutabarat","Miftahul Ulyana Hutabarat","Miftahul Ulyana Hutabarat","Developer","vdfvd","Miftahul Ulyana Hutabarat","Developer","Developer","Miftahul Ulyana Hutabarat","Miftahul Ulyana Hutabarat","Miftahul Ulyana Hutabarat","Developer","Developer","Developer","Miftahul Ulyana Hutabarat","cindai","Developer","Miftahul Ulyana Hutabarat","Developer","Developer","Miftahul Ulyana Hutabarat","Developer","Miftahul Ulyana Hutabarat","Developer","Miftahul Ulyana Hutabarat","Developer","Miftahul Ulyana Hutabarat","Miftahul Ulyana Hutabarat","Miftahul Ulyana Hutabarat","Miftahul Ulyana Hutabarat"],"nim":["data uji","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","0702192032","0702192033","333313","0702192031","0702192031","53252","0702192031","0702192031","0702192031","0702192031","0702192031","0702192031","07021920390","0702192032","0702192031","07021920309","0702192039"],"year":["data uji","2023","2023","2021","2021","2023","2023","2023","2023","2023","2023","2023","2023","2023","2023","2023","2023","2023","2023","4323","3454","4322","2023","2021","1234","4323","3454","3454","4322","2021","4323","4322","4322","3454","7586","2021"],"title":["cindai","nkjiuhilj","fvfdv","apalahkauni","apalahauni","fsfes","vbdvs","dfvsdfv","dcdscs","vvwc","vefvv","cdcdc","bhgth","jbjh","cfdsd","dscs","cdscds","cdca","edad","vva","dvvsdf","fafds","sgverv","xbzsb","dbvsb","jkbkb","hbjh"," hjmbmn","hjhg","bjhkj","etheh","jvmhsvvs","gvmjh","hghg","csCSdvdsv","fsvdfvdfv"]}'
# corpus = json.loads(corpus)

# name    = corpus['name']
# nim     = corpus['nim']
# year    = corpus['year']
# title   = corpus['title']

# corpus_combined = list(zip(name, nim, year, title))

# cosim = preprocess_tfidf_cosim(corpus_combined)

# data_dict = cosim.to_dict(orient='records')
# cosim = json.dumps(data_dict)

print(similarity)

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
        'Original Text': [text],
        'Lowercasing' : [lowercased_text],
        'Cleaning': [cleaned_text],
        'Tokenization': [tokenized_text],
        'Stemming': [stemmed_text],
        'Unique Words': [unique_words],
        'Stop Words': [stopwords_removed]
    })

    return df
    
#==================================================

def preprocess_tfidf_cosim(corpus):  
        
    def preprocessing(corpus):
        # Create DataFrames kosong
        df = pd.DataFrame(columns=['Name', 'Nim', 'Year', 'Original Text'])

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
            result_df['Name'] = name
            result_df['Nim']  = nim
            result_df['Year'] = year
            
            # satukan hasil preprocessing ke DataFrame utama sesuai dengan nama
            df = pd.concat([df, result_df], ignore_index=True)
        return df
    
    def tfidf(corpus):
        #paggil hasil preprocessing
        df = preprocessing(corpus)
        
        #membuat kolom baru dengan header kosong dan join setelah stopwords, memasukkan nilai bobot disetiap header yg kosong
        vectorizer = TfidfVectorizer()
        tfidf_matrix = vectorizer.fit_transform(df['Stop Words'].apply(' '.join))
        
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

