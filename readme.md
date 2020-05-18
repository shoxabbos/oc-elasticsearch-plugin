# How to use

## 1 step: Use searchable trait
```
class ExampleModel {
	use \Shohabbos\Elasticsearch\Classes\Searchable;
}
```


## 2 step: Search

#### Find one or find by id
```
$result = Post::elasticsearch()->find(10);
```

#### Query builder
```
// @var $result Collection
$result = Post::elasticsearch()
        ->select(['title', 'content'])
        ->orderBy("created_at")
        //->orderByDesc('created_at')
        ->limit(10)
        ->where(['content_html' => 'the'])
        //->whereIn('something', ['title^5', 'content'])
        //->rawQuery(['match' => ['field' => 'abs']])
        //->dumpParams()
        ->get();
```

