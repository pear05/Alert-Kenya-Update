from flask import Flask, request, render_template_string
from flask_mailman import Mail, EmailMessage

mail = Mail()

def create_app():
    app = Flask(__name__)
    app.config["MAIL_SERVER"] = "smtp.gmail.com"
    app.config["MAIL_PORT"] = 465
    app.config["MAIL_USERNAME"] = "waswaustin@gmail.com"
    app.config["MAIL_PASSWORD"] = "zovkvbcyimirgabc"
    app.config["MAIL_USE_TLS"] = False
    app.config["MAIL_USE_SSL"] = True

    mail.init_app(app)

    @app.route("/", methods=["GET", "POST"])
    def index():
        if request.method == "POST":
            recipients = request.form["recipient"].split(",")
            subject = request.form["subject"]
            body = request.form["message"]

            msg = EmailMessage(
                subject=subject,
                body=body,
                from_email="waswaustin@gmail.com",
                to=recipients
            )
            msg.send()
            return "Sent email(s)..."
        
        return render_template_string(html_form)

    return app

html_form = """
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Send Email</h2>
        <form method="post">
            <input type="text" name="recipient" placeholder="Recipient Emails (comma-separated)" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" placeholder="Message" rows="4" required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
"""

if __name__ == "__main__":
    app = create_app()
    app.run(debug=True)
