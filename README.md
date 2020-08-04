# Caliban WP Plugin

Set custom JS tracker properties using WP filters as long as these are called before the `wp_head` action is called.

### Examples:

**User Id**

```
Caliban\WP\ClientTracker::set('setUserId', 1357);
```

**Free-form key/value data** 
    
```
Caliban\WP\ClientTracker::set('setSessionExtraData', ['a' => 1, 'b' => 'c']);
```