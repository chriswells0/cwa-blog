# Core Web Application MVC Blog

Core Web Application MVC Blog provides everything needed to add a fully-functional blog to [Core Web Application Site](https://github.com/chriswells0/cwa-site). It includes database tables, models, views, controllers, and JavaScript/CSS.

## Features Included

* A minimalist blogging platform with a WYSIWYG blog post editor, tags, and an RSS feed.
* Multiple sharing options while respecting the privacy of your visitors by using [Social Share Privacy](https://github.com/panzi/SocialSharePrivacy).
* Blog comments and community powered by [Disqus](https://publishers.disqus.com/).
* All necessary code: just merge into the [Core Web Application Site](https://github.com/chriswells0/cwa-site) directory.
* Database script to create tables for blog posts and tags.

##### Features From [Core Web Application Site](https://github.com/chriswells0/cwa-site)

* A "starter" website with a home page, about page, and contact form.
* Responsive design that works well at multiple screen resolutions on devices of all sizes.
* Search engine (and human!) friendly URLs with a consistent format: /controller/method/parameter
* Ability to return data in a variety of content types such as HTML, JSON, or Atom/RSS by creating new view templates.
* Includes structured data to improve indexing by search engines.
* Error pages match the site design and can be easily customized for all errors or by HTTP status code.
* Site Admin section with multiple tools to facilitate common tasks:
  * Code Editor for minor ad-hoc changes
  * DB Administrator to perform queries and database backups
  * Log Viewer with filtering options
  * QA Assistant to review methods, parameters, and permissions

##### Features From [Core Web Application Libraries](https://github.com/chriswells0/cwa-lib)

* Lightweight and flexible base classes make it easy to master and extend the code.
* Uses the MVC design pattern and other web application best practices.
* Many built-in protections against common web application vulnerabilities/exploits:
  * Primarily uses prepared statements to deter SQL injection attacks.
  * Clickjacking defenses encompass multiple headers as well as JavaScript.
  * Automatic sanitization of simple variables passed to views and easy sanitization of other content to defend against cross-site scripting (XSS).
  * Cross-site request forgery (CSRF) prevention using the synchronizer token pattern for all POST requests.
  * Role-based method access is straightforward to configure and a cinch to validate with the QA Assistant.
  * User passwords are stored strongly hashed and salted.
  * Full session teardown and recreation upon login to inhibit session fixation.
  * Sessions are pinned to the user's IP and user agent string to thwart hijacking.

## Setup and Configuration

1. If you don't already have one, [create a Disqus account](https://disqus.com/admin/signup/) and generate one shortname for production and one for non-production.
2. Merge the code from this project into your [Core Web Application Site](https://github.com/chriswells0/cwa-site) directory.
3. Update application/config/config.php to set DISQUS_SHORTNAME using the shortnames you created in step 1.
4. Log into the database you created per the instructions in [Core Web Application Site](https://github.com/chriswells0/cwa-site) to execute the cwa-mvc-blog.sql script using the source command.
