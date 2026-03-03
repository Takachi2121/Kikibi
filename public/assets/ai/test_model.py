import os
import json
import time
from google import genai

# ==============================
# CONFIG
# ==============================
MODEL_NAME = "gemini-flash-lite-latest"
API_KEY = "AIzaSyCpc_RZndo9behjQdXIrkTQnHWgoOhVKUU"

if not API_KEY:
    raise ValueError("GEMINI_API_KEY belum diset.")

client = genai.Client(api_key=API_KEY)

# ==============================
# USER INPUT (misal dari web form)
# ==============================
user_data = {
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
}

# ==============================
# BUILD PROMPT
# ==============================
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

# ==============================
# SEND REQUEST TO GEMINI
# ==============================
start_time = time.time()

response = client.models.generate_content(
    model=MODEL_NAME,
    contents=[{"role": "user", "parts": [{"text": prompt}]}],
    config={
        "temperature": 0.7,
        "max_output_tokens": 800,
        "response_mime_type": "application/json"
    }
)

latency = round(time.time() - start_time, 2)
raw_text = response.text

print("\n================ RAW OUTPUT ================")
print(raw_text)

# ==============================
# EXTRACT JSON SAFELY
# ==============================
def extract_first_json(text):
    start = text.find("{")
    end = text.rfind("}")
    if start == -1 or end == -1:
        return None
    candidate = text[start:end+1]
    try:
        return json.loads(candidate)
    except:
        return None

parsed_json = extract_first_json(raw_text)

if parsed_json:
    print("\n================ PARSED JSON ================")
    print(json.dumps(parsed_json, indent=2, ensure_ascii=False))
else:
    print("\nJSON tidak valid atau tidak ditemukan.")

print(f"\nLatency: {latency} detik")
