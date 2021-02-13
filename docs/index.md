1. `header`
2. optional `head_notice`
3. optional `focus-area`
4.
```html

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <h1 class="main-title"></h1>

        <!-- if have posts -->

        <!-- is home & not frontpage -->
        <header><h1 class="page-title screen-reader-text"></h1></header>
        <!-- template part -->
    </main>
```
5. `pagenav_style == ajax`
```html
<div id="pagination"><?php next_posts_link(' Previous'); ?></div>
```