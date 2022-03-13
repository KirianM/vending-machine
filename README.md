# Vending Machine

## Project set up

Install and run the application.
```
docker/composer install
docker/build
```

## Running tests

```
docker/test
```

Only Acceptance tests

```
docker/test --testsuite acceptance
```

Only Unit tests

```
docker/test --testsuite unit
```

## Running system commands (Symfony console)

```
docker/console <command>
```

## How it works

Every command must be executed using the system console.

Sample:
```
docker/console machine:coins:return
```

### Insert coins

Add coins to machine balance.

```
service:change:set <coins>
```

Sample: 

```
service:change:set 0.25 0.25 0.1 0.05
```

---

### Return coins

Get back every coin inserted into the machine balance.

```
machine:coins:return
```

---

### List products

List every available product in the machine with their price and stock.

```
machine:products:list
```

---

### Buy product

Buy a product using the inserted coins.

```
machine:products:buy <product_name>
```

Sample: 

```
machine:products:buy Water
```

## Service commands

### Set available change

Manage the coins available for change.

```
service:change:set <coins>
```

Sample: 

```
service:change:set 0.25 0.25 0.1 0.05
```

---

### Set product stock

Manage the products availability.

```
service:products:set-stock <product_name> <stock>
```

Sample: 

```
service:products:set-stock Water 10
```