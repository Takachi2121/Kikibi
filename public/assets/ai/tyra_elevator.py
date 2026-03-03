import os
import json
import time
import csv
from datetime import datetime
from google import genai

# ==========================
# CONFIG
# ==========================
MODEL_NAME = "gemini-flash-lite-latest"  # Gunakan production model lebih stabil
CSV_FILE = "ai_rekomendasi_hadiah.csv"

DELAY_SECONDS = 5  # Bisa diperpanjang kalau perlu

# ==========================
# LOAD API KEY
# ==========================
API_KEY = os.getenv("GEMINI_API_KEY")
if not API_KEY:
    raise ValueError("GEMINI_API_KEY belum diset.")
client = genai.Client(api_key=API_KEY)

# ==========================
# USER INPUT (misal dari web form)
# ==========================
# Contoh data yang sama seperti Laravel AiController
USER_DATA_LIST = [
    {
        "nama": "Andi",
        "penerima": "Kakak",
        "usia": "18-25",
        "gender": "Pria",
        "level_kepentingan": "Tinggi",
        "momen": "Ulang Tahun",
        "prioritas": "Fungsional",
        "budget": 500000,
        "minat": "Gadget",
        "gaya": "Modern"
    },
    {
        "nama": "Sari",
        "penerima": "Teman",
        "usia": "26-35",
        "gender": "Wanita",
        "level_kepentingan": "Sedang",
        "momen": "Anniversary",
        "prioritas": "Estetik",
        "budget": 300000,
        "minat": "Fashion",
        "gaya": "Minimalis"
    }
]

# ==========================
# PROMPT BUILDER
# ==========================
def build_prompt(user_data):
    prompt_data = []
    for k, v in user_data.items():
        if v:
            prompt_data.append(f"- {k}: {v}")

    prompt = f"""
Kamu adalah AI asisten rekomendasi hadiah untuk UMKM lokal.

Tugasmu:
Berikan SARAN KARAKTERISTIK HADIAH (bukan nama produk).

Data yang tersedia:
{chr(10).join(prompt_data)}

Balas HANYA dalam format JSON berikut (tanpa teks tambahan):
{{
    "kategori": [""],
    "gaya": [""],
    "kata_kunci": [""],
    "alasan": ""
}}
"""
    return prompt

# ==========================
# CSV INIT
# ==========================
file_exists = os.path.isfile(CSV_FILE)

with open(CSV_FILE, mode="a", newline="", encoding="utf-8") as file:
    writer = csv.writer(file)

    if not file_exists:
        writer.writerow([
            "timestamp",
            "model",
            "user_nama",
            "latency_sec",
            "json_valid",
            "kategori",
            "gaya",
            "kata_kunci",
            "alasan",
            "raw_text",
            "error_message"
        ])

    # ==========================
    # LOOP USER DATA
    # ==========================
    for user_data in USER_DATA_LIST:
        raw_text = ""
        error_message = ""
        json_valid = False
        kategori = ""
        gaya = ""
        kata_kunci = ""
        alasan = ""
        latency = 0

        prompt = build_prompt(user_data)
        start_time = time.time()

        try:
            response = client.models.generate_content(
                model=MODEL_NAME,
                contents=[{"role": "user", "parts": [{"text": prompt}]}],
                config={
                    "temperature": 0.7,
                    "max_output_tokens": 600,
                    "response_mime_type": "application/json"
                }
            )

            latency = round(time.time() - start_time, 2)
            raw_text = response.text

            try:
                parsed = json.loads(raw_text)
                json_valid = True
                kategori = parsed.get("kategori", "")
                gaya = parsed.get("gaya", "")
                kata_kunci = parsed.get("kata_kunci", "")
                alasan = parsed.get("alasan", "")
            except Exception as json_err:
                error_message = f"JSON Error: {str(json_err)}"

        except Exception as e:
            error_message = str(e)

        writer.writerow([
            datetime.now().isoformat(),
            MODEL_NAME,
            user_data.get("nama", ""),
            latency,
            json_valid,
            kategori,
            gaya,
            kata_kunci,
            alasan,
            raw_text,
            error_message
        ])

        print(f"[RUN] User={user_data.get('nama')} | JSON={json_valid} | Latency={latency}s")
        time.sleep(DELAY_SECONDS)
