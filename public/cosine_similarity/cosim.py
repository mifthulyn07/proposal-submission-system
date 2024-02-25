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
    combined = zip(name, year, title)
    make_list = np.array(list(combined))

    return make_list

def json_encode(data, data_api, cosim, execution_time):
    # satukan
    data = np.concatenate((data, data_api))
    cosim = np.insert(data, data.shape[1], cosim, axis=1)

    # inisialkan setiap kolom 
    import pandas as pd
    cosim_df = pd.DataFrame(cosim, columns=['name_summary', 'nim_uniquecode', 'year_link', 'title', 'cosim'])

    # kirim ke laravel berbentuk list
    cosim = json.dumps(cosim_df.to_json(orient='records'))

    return cosim

def google_scholar_api(search):
    params = {
        "engine": "google_scholar",
        "q": search,
        "api_key": "ef443d32e257ef6bb616789623d38dd5ced93df23a97cd9a9ee4801c48605026",
        "num": "20",
        "hl": "id"
    }

    search  = GoogleSearch(params)
    results = search.get_dict()
    if results["search_information"]["organic_results_state"] == "Results for exact spelling":
        gs_api  = results['organic_results']

        summary     = [item['publication_info']['summary'] for item in gs_api]
        result_id   = [item['result_id'] for item in gs_api]
        link        = [item.get('link') for item in gs_api]
        title       = [item['title'] for item in gs_api]

        # make a list 
        combined = zip(summary, result_id, link, title)
        result = np.array(list(combined))
    else:
        result = None
    
    return result

#=================================================

if __name__ == '__main__':
    start = timeit.default_timer()

    # print(cosim(sys.argv[1]))
    data = '{"name":["data uji","Prof. Tre Dickens I","Dewitt OConnell","Clinton Parker","Colt Kulas III","Amari Abshire","Miftahul Ulyana Hutabarat"],"year":["data uji","1974","2021","2013","2013","1991","2021"],"title":["OPTIMASI SISTEM INFORMASI PENGAJUAN JUDUL TUGAS AKHIR MAHASISWA BERBASIS WEB MENGGGUNAKAN METODE TF-IDF DAN COSINE SIMILARITY PADA PRODI SISTEM INFORMASI UINSU MEDAN","Rancang Bangun Sistem Informasi Manajemen Aset","Rancang Bangun Sistem Informasi Pengajuan Judul Tugas Akhir Mahasiswa","Rancang dan Bangun Sistem Aplikasi E-Commerce","Rancang dan Bangun Sistem Informasi Geografis Sekolah","Rancang Bangun Sistem Pendukung Keputusan Gizi Balita","Rancang Rancang Bangun Sistem Informasi Manajemen Uang"]}'
    # data = '{"name":["data uji"],"nim":["data uji"],"year":["data uji"],"title":["dnmfns nghfkj bsfjbdnsjfdbnsfjd bsnbjsbns"]}'
    # data ='{"name":["data uji","Ms. Willa Doyle MD","Cruz Osinski","Lue Hermann","Destiney Sawayn","Mr. Ludwig Zieme V","Destiny Kuvalis","Allene Tromp III","Prof. Velva DAmore","Christopher Lueilwitz","Stephon Mertz","Henriette Abshire","Verdie Fadel","Mr. Nicola Barrows","Ezekiel Rolfson","Dr. Emanuel Hamill Jr.","Prof. Shad Bruen","Moses Murphy Jr.","Savannah Kuhn Jr.","Eddie Murray Jr.","Andres Mertz","Eddie Nader DVM","Dr. Elbert Rodriguez","Jude Rogahn","Jovanny Kuvalis","Dr. Floyd Grimes","Dr. Broderick Gusikowski IV","Olin Tremblay","Savion Marks","Hector Botsford","Schuyler Smith","Berry Toy","Miss Larissa Bernhard IV","Dr. Tia Rohan","Mrs. Zelma Dooley","Christelle Brekke","Ms. Shanna Jast DDS","Mattie Kohler","Leonie Nader","Emory Cartwright","Dr. Gilda Rolfson DDS","Grant Jast","Darryl Windler","Antonio Schoen","Freeda Bednar","Magnus Dibbert","Prof. Flossie Rodriguez","Prof. Isobel Prohaska IV","Eriberto White","Jaqueline Willms PhD","Adrain Denesik III","Ms. Rosalind Hilpert III","Estella White I","Shawn Feeney MD","Miss Rosalyn Russel DVM","Thelma Balistreri III","Brandy Herzog","Pansy Smitham DVM","Esther Beahan","Jocelyn Thiel","Obie King DDS","Skylar VonRueden","August Denesik","Eduardo Hartmann","Thelma Stoltenberg","Dillon Upton III","Hosea Crooks","Wava Wunsch","Crystal Orn","Jared Torphy MD","Emilia Runolfsson","Alexandrea Greenholt","Rex Auer","Dr. Ladarius Skiles Sr.","Ephraim Howell","Miss Rosanna Greenfelder IV","Mikayla Ward","Laisha Strosin","Mr. Jaycee Ondricka I","Adella Botsford","Kylee Hane","Charlie Jacobi Jr.","Jackeline OConner","Jazmin Williamson","Shanna Haag","Ms. Destinee Jakubowski","Kolby Kutch","Jules Jakubowski","Cordelia Rath","Bernadette VonRueden PhD","Salvador Rogahn","Quinn Ankunding","Michel Sawayn","Rosalind OHara","Damaris Kunde","Donny Nolan","Marcos Schinner","Eloy Swift","Fidel Murphy","Marielle Schulist","Prof. Silas Nader DVM"],"nim":["data uji","5670411746","8807880419","8853809997","8665955503","6809140023","9446458386","4851426245","8732753941","7306533835","4619893902","7499349934","4397328023","4064928423","9858086482","9607356348","7444303889","3191387318","4361237221","4841126862","1181800492","5769405897","2687917928","1859894798","5391793995","8829134928","2515528214","4597997020","5438902603","3508841930","4383154123","4509774732","3407010712","9959201945","5069433486","5778509831","1864392298","6176304333","4877014921","3935292619","3084858247","7709949199","5383100264","9510950648","8335775397","6437094700","5659024505","7876415182","8717216391","5794497884","4822657029","3806585663","6261681013","8169342257","1062032876","9196841252","5865476866","7710416869","4389457890","4970591966","6728252880","9397161921","2310983063","9432955123","1145670061","4503654056","5595265215","7238865039","3763067766","7274041385","4644067377","2695943037","5703736499","1599179289","6313907867","9619713687","1341201429","9698830485","5846201819","4386571562","3523200401","9068644059","3536901095","9427220616","2859752262","7504000567","6556571447","2269138388","9878690370","7971182657","5274288884","6693515830","6829468281","4978322268","6651354103","2436281957","4821414478","5465674407","4169433157","6136417421","1388937750"],"year":["data uji","1986","1994","2016","2013","2023","2019","1979","1986","2008","2000","2011","1970","2016","2020","2002","2005","1985","1992","1982","2005","2019","1992","2008","2006","1980","1991","1999","2018","2016","1998","1987","2017","1999","2019","1982","1998","2019","1983","2021","1977","2021","1974","1995","1974","2018","1986","1988","2010","1974","1971","1986","1996","1972","2019","2000","1984","1994","1997","1984","1974","2010","1993","2018","2016","1989","1994","2023","2014","1994","2010","1992","1985","1994","1992","2000","1975","2003","1971","1984","2007","2015","1977","2018","1976","2021","1988","1971","2020","2004","2005","2018","1998","1989","2016","1980","2010","1988","2008","1975","2003"],"title":["sistem informasi uang desa","Aplikasi pedesaan","sistem informasi perudang-undangan","Sistem informasi geografis aplikasi","Sit a dolor minima aperiam sit.","Quia tempora molestiae eveniet veritatis officia in est.","Quidem placeat modi inventore qui eveniet ut fugiat.","Ut incidunt autem beatae aut ipsum.","Et adipisci iure vitae vitae qui.","Vel sit atque rem.","Nihil voluptas et sapiente vel voluptatem.","Unde est ut officiis quibusdam facere tenetur est accusantium.","Similique eos expedita labore aliquam porro officia porro.","Voluptatem numquam illo nemo inventore accusantium voluptates ut quidem.","Atque molestias provident occaecati nemo sequi repellendus qui voluptatem.","Est occaecati non et labore consequuntur nihil.","Error quis nulla et earum dolorem suscipit deleniti.","Labore rem minima omnis sint veritatis.","Perferendis consequuntur ut quae qui.","Dolore ducimus vel eligendi sit modi.","Aut magnam quam est rem eos qui.","Et unde laudantium possimus.","Ut autem aspernatur eos vel nesciunt sint.","Molestiae sequi error ad perferendis.","Autem eveniet non beatae.","Repellat nihil ullam aspernatur inventore saepe dignissimos quam.","Repellat dignissimos quisquam commodi.","Quo molestiae fuga aut sed nemo.","Quam quo quis non.","Iste praesentium sit laboriosam perspiciatis.","Aut enim et cum corrupti.","Consequatur illum ab harum voluptate quia.","Nostrum ea est ratione.","Qui fugit nam ut natus.","Ipsa repellat quod ipsam magnam expedita laudantium et.","Delectus qui iure ea quibusdam sit.","Accusamus dolor rerum ea cum voluptatem laborum reprehenderit.","Neque et sed ut.","Fuga sit ratione ut aut.","Voluptatem magnam eum ut voluptatibus.","Ad fugiat blanditiis culpa magni.","Vero distinctio at quis autem officia corporis reiciendis.","Rem aspernatur veritatis repellendus quibusdam beatae consequuntur.","Laborum sit totam aut odit fugit optio.","Debitis voluptatem doloremque recusandae distinctio eos.","A labore eos omnis vel error.","Iusto ea fuga vitae iusto praesentium aperiam et.","Rerum ut rem eius.","Quo vitae qui sed harum.","Qui qui architecto impedit et quia sunt qui et.","Qui aut enim necessitatibus cum.","Laborum sed fugit voluptatibus velit.","Sequi laboriosam quia enim ut dolorem similique ratione et.","Recusandae repellat in omnis tempore est molestiae odit nisi.","Vel ut dignissimos omnis cupiditate.","Voluptate aliquid a quidem aut.","Sed officia dignissimos quo est deserunt.","Maxime numquam nam exercitationem dolorem rerum.","Aut rerum atque dolorum reiciendis aperiam sunt facilis.","Amet magni mollitia minima minus porro.","Consequatur libero odit in corporis ipsum.","Earum ut ut dicta possimus id.","Laudantium qui fugit et et.","Quos ut quia ipsam sunt in vero dolorem.","Perferendis consequatur eum a reiciendis.","Dolorem ut autem sunt voluptates voluptatum.","Et cupiditate libero occaecati qui temporibus deleniti.","Aliquam sunt reprehenderit voluptate reiciendis aut perferendis.","Voluptatem neque quos et voluptatem ipsa totam recusandae.","Quae veritatis sunt iure sunt perspiciatis iure earum.","Ea voluptatibus quas eligendi et doloremque.","Velit incidunt ut minima suscipit ea.","Voluptatum molestiae sit qui.","Neque et aut eos sed.","Aut eos dolore veritatis ea nam ab.","Laborum quidem et autem debitis error sed corporis.","Necessitatibus eos id quo expedita error qui tempora.","Et dignissimos provident fugiat dolor eveniet et.","Voluptatem quia temporibus est voluptatem numquam beatae similique accusamus.","Adipisci fugiat adipisci exercitationem dolores molestiae.","Vel sit impedit accusamus a autem et ut.","Sint dolorem occaecati eligendi praesentium.","Iusto eum facilis quis blanditiis.","Eligendi enim ab sed et tempore sint odit aperiam.","Enim consequatur nihil quidem vel.","Omnis iusto quo asperiores dolore hic provident.","Non et cumque sapiente voluptate perferendis quod maxime possimus.","Deleniti qui qui ea quis omnis aliquam sunt.","Voluptatem tempore assumenda nobis molestiae repudiandae.","Quae consequatur dolore voluptates qui quae molestiae.","Est ut exercitationem saepe quis similique.","Delectus delectus qui veniam eos velit dicta.","Deserunt temporibus omnis doloremque ea molestiae ipsum harum.","Natus ab qui tempora.","Mollitia magnam autem nulla ut voluptate et mollitia.","Assumenda natus consequatur magnam quia quis aut.","Itaque quisquam expedita sed.","Id delectus praesentium accusantium sed provident dolorum.","Molestiae aut sunt quis illum.","Dolore modi fugit aliquid aut qui numquam qui.","Harum odit ipsam qui eius."]}'
    # data = '{"name":["data uji"], "nim":["data uji"], "year":["data uji"], "title":["Optimasi Sistem Informasi Pengajuan Judul Tugas Akhir Mahasiswa  Berbasis Web Mengggunakan Metode TF-IDF Dan Cosine Similarity Pada  Prodi Sistem Informasi UINSU Medan"]}'
    # data from laravel
    import sys
    # data            = json_decode(sys.argv[1])
    data            = json_decode(data)
    corpus_laravel  = data[:, 2]
    # print(corpus_laravel)

    # data from google scholar 
    data_api    = google_scholar_api(data[0, 3])

    if data_api is None:
        # kirim ke laravel berbentuk list
        cosim = json.dumps(None)
        print(cosim) 
    else:
        corpus_api  = data_api[:, 3]

        # satukan corpus_data dan corpus_api
        corpus = np.concatenate((corpus_laravel, corpus_api))

        # run
        pool = mp.Pool()
        preprocess_result = pool.map(preprocess_text, corpus)
        tfidf_result = calculate_tfidf(preprocess_result)
        cosim_result = cosineSimilarity(tfidf_result)
        pool.close()
        pool.join()

        stop = timeit.default_timer()
        execution_time = stop - start

        # encode json
        result = json_encode(data, data_api, cosim_result, execution_time)

        print(result)
        # print(execution_time)
    