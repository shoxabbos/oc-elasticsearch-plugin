# How to use

## 1 step: Use searchable trait
```
class Post
{
    public $implement = ['Shohabbos.Elasticsearch.Classess.Searchable'];

    // optional
    // public $useSearchIndex = 'index';

    // optional
    // public $useSearchType = 'type';

    // optional
    // You can specify the fields to be indexed.
    // public function toSearchArray() {
    //      return [
    //            'title' => $this->title
    //      ];
    // }
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

