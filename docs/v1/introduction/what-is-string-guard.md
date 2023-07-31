# String Guard

![yormy](../../public/yormy.png)

::: tip Definition

:::

## Goal

## Features


# Goal
StringGuard provides and easy way to configure whether to include or exclude a string in further processing.
This sounds abstract, and yes it is.

# Example
You are building something whereby you need to be able to config whether a certain url needs to be processed or not.
This can be simply done by string comparison to an array of urls... if so simple... do it like that.

It becomes more complex when you want to :
- allow wildcards
- exclude certain urls

# Example 1
You want to include all urls like the members , urls starting with ```example.com/member```
so
- example.com/member/dashboard
- example.com/member/account

However
You do not want to include
- example.com/member/payments

# Example 2
You want to include ALL urls
However, you do not want to include anything that starts with ```google.com```

# Example 3
You want to include
- example.com/member/dashboard
- example.com/member/account

You want to exclude
- example.com/member/payments , but only the POST methods, you want to INCLUDE the get methods

# Example 4
You want to include
- example.com/member/account, but only the DELETE method, the rest you want to exclude

See... it can get pretty complicated pretty fast.

That is the reason I wrote this package, I needed it for other projects, and now you can use it too.


# Docs

```php
'example.co*' => [
    'conditions' => [
        'methods' => ['post', 'de*']
        'days' => ['sund', 'friday']
    ],
    'data' = [],
]