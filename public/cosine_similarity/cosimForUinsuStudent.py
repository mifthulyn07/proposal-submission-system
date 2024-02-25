#!C:/Users/Administrator/anaconda3/python.exe
import multiprocessing as mp
import json
import numpy as np
import nltk 
nltk.download('stopwords', quiet=True)

#==================================================

def preprocess_text(text):
    # lowercasing
    lowercased_text = text.lower()

    # cleaning 
    import re 
    remove_punctuation = re.sub(r'[^\w\s]', '', lowercased_text)
    remove_white_space = remove_punctuation.strip()

    # Tokenization = memecah tiap kalimat menjadi array
    from nltk.tokenize import word_tokenize
    tokenized_text = word_tokenize(remove_white_space)

    # Stop Words = menghapus kata kata yang tidak penting = filtering
    from nltk.corpus import stopwords
    stopwords_indonesia = set(stopwords.words('indonesian'))
    stopwords_removed = [word for word in tokenized_text if word not in stopwords_indonesia]

    # Stemming = normalisasi data ke dalam bentuk dasar 
    from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
    factory = StemmerFactory()
    stemmer = factory.create_stemmer()
    stemmed_text = [stemmer.stem(word) for word in stopwords_removed]

    return stemmed_text
        
def calculate_tfidf(corpus):
    # make each array row from stopwords_removed to be a sentence
    stopwords_removed = [' '.join(item) for item in corpus]
    
    # count tf-idf
    from sklearn.feature_extraction.text import TfidfVectorizer
    vectorizer = TfidfVectorizer()
    tfidf_result = vectorizer.fit_transform(stopwords_removed)
    
    return tfidf_result

def cosineSimilarity(corpus):
    # Menghitung cosine similarity antara item pertama dan semua item lainnya
    from sklearn.metrics.pairwise import cosine_similarity
    cosim = cosine_similarity(corpus[0:1], corpus)
    
    # menghitung persenan dibulatkan
    cosim_percent = np.trunc((cosim * 100))

    return cosim_percent

#=================================================

def json_decode(data):
    # ambil dari laravel
    data = json.loads(data)

    name    = data['name']
    year    = data['year']
    title   = data['title']

    # make a list 
    combined = zip(name, year, title)
    make_list = np.array(list(combined))

    return make_list

def json_encode(data, cosim):
    # satukan
    cosim = np.insert(data, data.shape[1], cosim, axis=1)

    # inisialkan setiap kolom 
    import pandas as pd
    cosim_df = pd.DataFrame(cosim, columns=['name', 'year', 'title', 'cosim'])

    # kirim ke laravel berbentuk list
    cosim = json.dumps(cosim_df.to_json(orient='records'))

    return cosim

#=================================================

if __name__ == '__main__':

    import sys
    # print(sys.argv[1])
    data            = json_decode(sys.argv[1])
    corpus_laravel  = data[:, 2]

    # data            = '{"name":["data uji","Prof. Tre Dickens I","Dewitt OConnell","Clinton Parker","Colt Kulas III","Amari Abshire","Miftahul Ulyana Hutabarat"],"year":["data uji","1974","2021","2013","2013","1991","2021"],"title":["OPTIMASI SISTEM INFORMASI PENGAJUAN JUDUL TUGAS AKHIR MAHASISWA BERBASIS WEB MENGGGUNAKAN METODE TF-IDF DAN COSINE SIMILARITY PADA PRODI SISTEM INFORMASI UINSU MEDAN","Rancang Bangun Sistem Informasi Manajemen Aset","Rancang Bangun Sistem Informasi Pengajuan Judul Tugas Akhir Mahasiswa","Rancang dan Bangun Sistem Aplikasi E-Commerce","Rancang dan Bangun Sistem Informasi Geografis Sekolah","Rancang Bangun Sistem Pendukung Keputusan Gizi Balita","Rancang Rancang Bangun Sistem Informasi Manajemen Uang"]}'
    # data            = json_decode(data)
    # corpus_laravel  = data[:, 2]
    
    pool = mp.Pool()
    preprocess_result = pool.map(preprocess_text, corpus_laravel)
    tfidf_result = calculate_tfidf(preprocess_result)
    cosim_result = cosineSimilarity(tfidf_result)
    pool.close()
    pool.join()

    results = json_encode(data, cosim_result)

    print(results)
    