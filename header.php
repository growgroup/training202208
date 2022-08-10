<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>テストサイト</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <?php wp_head() ?>
</head>

<body <?php body_class() ?>>
    <?php wp_body_open() ?>
    <header class="l-header">
        <div class="l-container">
            <h1 class="l-header__logo">サイトタイトル</h1>
            <nav class="l-header__nav">
                <ul>
                    <li>
                        <a href="#info">お知らせ</a>
                    </li>
                    <li>
                        <a href="./archive-places.html">名所</a>
                    </li>
                    <li>
                        <a href="#contact">お問い合わせ</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
