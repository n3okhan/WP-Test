# WP-Test
Consuming external API using wordpress

# Setup notes 
1. Copy the MenuTest.php under wordpress plugin directory and activate the plugin

2. Create a fake api using REST API with JSON Server (https://github.com/typicode/json-server).
### file name db.json 
`
{
  "categories": [
    {
      "id": 1000,
      "name": "State",
      "parent_id": null
    },
    {
      "id": 1001,
      "name": "NSW",
      "parent_id": 1000
    },
    {
      "id": 1002,
      "name": "VIC",
      "parent_id": 1000
    },
    {
      "id": 1003,
      "name": "QLD",
      "parent_id": 1000
    },
    {
      "id": 1004,
      "name": "WA",
      "parent_id": 1000
    },
    {
      "id": 1005,
      "name": "ACT",
      "parent_id": 1000
    },
    {
      "id": 1006,
      "name": "National",
      "parent_id": null
    },
    {
      "id": 1007,
      "name": "World",
      "parent_id": null
    }
  ]
}
`

# Work left in progress
- 30 Minutes check

# How long the test took to complete
It took me 10-12 hours

# My thoughts
I am not a PHP or WordPress backend Dev.

This is the first time I did something like this on WordPress. 

I really enjoyed developing it and it was really fun learning this aspect of WordPress.

Since its a plugin you can enable and disable this feature


