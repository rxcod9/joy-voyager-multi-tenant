[![Latest Version](https://img.shields.io/github/v/release/rxcod9/joy-voyager-multi-tenant?style=flat-square)](https://github.com/rxcod9/joy-voyager-multi-tenant/releases)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/rxcod9/joy-voyager-multi-tenant/tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/joy/voyager-multi-tenant.svg?style=flat-square)](https://packagist.org/packages/joy/voyager-multi-tenant)

# **Joy Voyager Multi Tenant**
By 🐼 [Ramakant Gangwar](https://github.com/rxcod9)

<hr>

Laravel Admin & BREAD System with Multi tenant support

## Working Example

You can try demo here<br/>
Central Admin [https://joy-voyager-multi-tenant.kodmonk.com](https://joy-voyager-multi-tenant.kodmonk.com)<br/>
Domain 1 Tenant 1 Admin [https://domain-1-tenant-1.kodmonk.com](https://domain-1-tenant-1.kodmonk.com)<br/>
Domain 2 Tenant 1 Admin [https://domain-2-tenant-1.kodmonk.com](https://domain-2-tenant-1.kodmonk.com)<br/>
Domain 1 Tenant 2 Admin [https://domain-1-tenant-2.kodmonk.com](https://domain-1-tenant-2.kodmonk.com)<br/>
Domain 2 Tenant 2 Admin [https://domain-2-tenant-2.kodmonk.com](https://domain-2-tenant-2.kodmonk.com)

## Installation Steps

### 1. Clone repo/Install Using Composer

You can clone/install the `Joy Voyager Multi Tenant` with the following commands:

```bash
git clone git@github.com:rxcod9/joy-voyager-multi-tenant.git
cd joy-voyager-multi-tenant

# OR Install using composer
composer create-project joy/voyager-multi-tenant
cd voyager-multi-tenant
```

### 2. Add the DB Credentials & APP_URL

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

You will also want to update your website URL inside of the `APP_URL` variable inside the .env file:

```
APP_URL=http://localhost
APP_CENTRAL_HOST=localhost
```

### 3. Run The Installer

To install simply run

```bash
./vendor/bin/sail up -d
chmod +x sail-rebuild.sh
. ./sail-rebuild.sh
```

And we're all good to go!

And, visit <br/>
[http://localhost/admin](http://localhost/admin)<br/>
[http://domain-1-tenant-1.localhost/admin](http://domain-1-tenant-1.localhost/admin)<br/>
[http://domain-2-tenant-1.localhost/admin](http://domain-2-tenant-1.localhost/admin)<br/>
[http://domain-1-tenant-2.localhost/admin](http://domain-1-tenant-2.localhost/admin)<br/>
[http://domain-2-tenant-2.localhost/admin](http://domain-2-tenant-2.localhost/admin).
