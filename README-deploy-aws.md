# Deploying Laravel 8 to AWS Elastic Beanstalk

## Prerequisites
- AWS account
- AWS CLI & EB CLI installed
- Code is ready (including .ebextensions/laravel.config)

---

## Deploy: Step by Step

1. **Initialize Elastic Beanstalk config in the project root:**
   ```bash
   eb init
   # Choose region, PHP platform (8.x), etc
   ```

2. **Create your environment:**
   ```bash
   eb create laravel-env
   # Use t2.micro for free tier if available
   ```

3. **Set your environment variables:**
   (Replace values as needed)
   ```bash
   eb setenv APP_KEY=base64:YOUR_APP_KEY APP_ENV=production APP_DEBUG=false DB_CONNECTION=mysql DB_HOST=YOUR_RDS_HOST DB_PORT=3306 DB_DATABASE=DB_NAME DB_USERNAME=USERNAME DB_PASSWORD=PASSWORD
   ```

4. **Deploy:**
   ```bash
   eb deploy
   ```

5. **Visit your app:**
   Use the provided Elastic Beanstalk endpoint (see eb CLI output or AWS Console).

---

## Notes
- `storage` and `bootstrap/cache` write permissions are set automatically via `.ebextensions/laravel.config`.
- Migrations run after each deployment (see `.ebextensions/laravel.config`).
- PHP timezone set to UTC (edit .ebextensions/laravel.config if another is needed).
- For HTTPS/domain setup, see Elastic Beanstalk documentation on SSL & custom domains.
- For troubleshooting: Check logs with `eb logs` or AWS Console.

---
