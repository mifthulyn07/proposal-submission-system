#!C:/Users/Administrator/anaconda3/python.exe
import multiprocessing as mp
import json
import numpy as np
import nltk 
nltk.download('stopwords', quiet=True)

# google scholar api 
import requests
from serpapi import GoogleSearch

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
    make_list = np.array([[name], [year], [title]])

    return make_list

def json_encode(data_api, cosim):
    # satukan
    cosim = np.vstack((data_api, cosim))
    cosim_transposed = cosim.T

    # inisialkan setiap kolom 
    import pandas as pd
    cosim_df = pd.DataFrame(cosim_transposed, columns=['summary', 'link', 'title', 'cosim'])

    # kirim ke laravel berbentuk list
    cosim = json.dumps(cosim_df.to_json(orient='records'))

    return cosim

def google_scholar_api(search):
    params = {
        "engine": "google_scholar",
        "q": search,
        "api_key": "4c4796a5ad72155efbc678c29c75d3889816dbdb5d2356c7a353f8bf4fce6f43",
        "num": "10",
        "hl": "id"
    }

    search  = GoogleSearch(params)
    results = search.get_dict()
    if results["search_information"]["organic_results_state"] == "Results for exact spelling":
        gs_api  = results['organic_results']

        # masih berbentuk list 
        summary     = [item['publication_info']['summary'] for item in gs_api]
        link        = [item.get('link') for item in gs_api]
        title       = [item['title'] for item in gs_api]

        # buat dalam bentuk array 
        summary = np.array(summary)
        link    = np.array(link)
        title   = np.array(title)

        results = np.array([summary, link, title])
    else:
        results = None
    
    return results

#=================================================

if __name__ == '__main__':
    
    import sys
    data        = json_decode(sys.argv[1])
    data_api    = google_scholar_api(data[2])

    if data_api is None:
        # kirim ke laravel berbentuk list
        cosim = json.dumps(None)
        print(cosim) 
    else:
        # satukan corpus_data dan corpus_api
        corpus = np.insert(data_api, [0], data, axis=1)

        corpus_api  = corpus[2, :]

        # run
        pool = mp.Pool()
        preprocess_result = pool.map(preprocess_text, corpus_api)
        tfidf_result = calculate_tfidf(preprocess_result)
        cosim_result = cosineSimilarity(tfidf_result)
        pool.close()
        pool.join()

        # encode json
        result = json_encode(corpus, cosim_result)
        print(result)
