<footer id="footer" class="wb">
<div class="container">
    <nav class="text-center">
        <?php
        $headerMenu = config('navigation.footer');
        if($headerMenu){
            foreach($headerMenu as $item){
                list($title, $url) = configToNavItem($item);
                echo '<a href="'.$url.'">'.$title.'</a>';
            }
        }
        ?>
    </nav>
</div>
</footer>
