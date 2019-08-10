<aside class="col-md-4">

    <?php
    $blogKats = json_decode(json_encode(getCategoriesWithSub()));
    if($blogKats): ?>
    <div class="wb p10">
        <div class="bstitle"><em class="glyphicon glyphicon-list"></em> Kategoriler</div>
        <ul class="bslist">
        <?php foreach ($blogKats as $key => $item): ?>
            <li><a href="{{ route('blog.category', ['slug'=>$item->slug]) }}">{{ $item->title }}</a></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

</aside>
