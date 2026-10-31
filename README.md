# Rag-Shop-Ai-Assistant

An advanced, privacy-first, multimodal e-commerce assistant built with **Laravel 13**, **PHP 8.3**, and **Ollama (Gemma 4)**. This project integrates a powerful **RAG (Retrieval-Augmented Generation)** pipeline for real-time inventory and database query matching, alongside **Multimodal Vision Analysis** to let customers upload images for instant product identification and support.

---

## 🚀 Full Project Features

* **Multimodal Visual Search & Support:** Customers can upload images (e.g., product photos, damaged items, or reference pictures), and Gemma 4 will locally analyze the pixels to understand context, identify items, and answer questions.
* **RAG-Powered Database Retrieval:** Dynamically queries your local MySQL shop database for real-time inventory levels, pricing, specifications, and previous store feedback.
* **Smart Store Feedback & Q&A:** Processes customer feedback, queries store policies, and provides accurate support agents completely offline.
* **100% Local Privacy:** Runs fully on your hardware via Ollama. No customer queries, chat logs, or uploaded images are sent to external third-party cloud servers.
* **Modern Tech Stack:** Built on the latest Laravel 13 features and PHP 8.3 architecture.

---

## 🛠️ Complete System Requirements

Before you begin, ensure your machine has the following installed:
* **PHP 8.3** (with extensions: Ctype, cURL, DOM, Fileinfo, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML)
* **Composer** (latest version)
* **Node.js & NPM** (for frontend asset compilation)
* **MySQL / MariaDB** (or Docker Desktop for local containerized database)
* **Ollama** installed on your operating system.

---

## ⚙️ Step-by-Step Installation Guide

### Step 1: Clone the Repository
Open your terminal and clone the repository to your local machine:
```bash
git clone https://github.com/your-username/Rag-Shop-Ai-Assistant.git
cd Rag-Shop-Ai-Assistant
```

### Step 2: Install PHP Dependencies (Laravel 13 & All Composer Packages)
Install all required backend packages and dependencies:
```bash
composer install
```

### Step 3: Install Frontend Dependencies
Install and compile frontend node modules:
```bash
npm install
```

### Step 4: Environment Configuration
Copy the sample environment file to create your active `.env` configuration:
```bash
cp .env.example .env
```

Generate your unique Laravel application encryption key:
```bash
php artisan key:generate
```

Open your `.env` file in your code editor and configure your database and Ollama connection settings:
```env
APP_NAME="Rag Shop AI Assistant"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rag_shop_db
DB_USERNAME=root
DB_PASSWORD=your_database_password

# Local Ollama AI Engine Settings
OLLAMA_BASE_URL=http://localhost:11434
OLLAMA_MODEL=gemma4:latest
```

### Step 5: Run Database Migrations and Seeders
Create your database tables (products, inventory, feedback, and chat histories) and seed them with initial shop mock data:
```bash
php artisan migrate --seed
```

---

## 🦙 Setting Up Ollama and Gemma 4

To run the local intelligence and vision engine:

1. Download and install [Ollama](https://ollama.com/) for your operating system (Windows, macOS, or Linux).
2. Open your terminal and pull the **Gemma 4** model (which supports both text generation and multimodal vision capabilities):
   ```bash
   ollama pull gemma4:latest
   ```
3. Verify that the model is running and loaded correctly by starting Ollama or checking active models:
   ```bash
   ollama list
   ```
   *(Ensure Ollama's background service is running on `http://localhost:11434` when using the application).*

---

## 🏃 Running the Application

To run the project locally, you will need two separate terminal windows open:

**Terminal 1: Start the Laravel Development Server**
```bash
php artisan serve
```

**Terminal 2: Start Vite for Frontend Assets**
```bash
npm run dev
```

Open your browser and navigate to `http://localhost:8000` to interact with your local RAG Shop AI Assistant!

---

## 🔄 How the RAG & Vision Pipeline Operates

1. **User Input & Attachment:** A user submits a query and can optionally attach an image file through the chat UI.
2. **Local Vision Processing:** Laravel passes the image and prompt to Ollama, where **Gemma 4** analyzes the visual content locally.
3. **Database RAG Search:** Laravel searches your MySQL product catalog and store feedback tables based on keywords or vector similarity.
4. **Context Synthesis:** The system aggregates the visual description and database records into a single prompt context, allowing Gemma 4 to output precise, real-time answers.

---

## 📄 License

This project is open-source software licensed under the [MIT license](LICENSE).
