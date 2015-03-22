<?php require_once 'lib/php/Freeboard.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Overview of status boards</title>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="viewport" content = "width = device-width, initial-scale = 1, user-scalable = no" />
    <link href="css/freeboard.css" rel="stylesheet" />
    <style>
        a { color: #8b8b8b; font-size: 24px;}
        .gridster .gs_w { position: relative; }
        .gridster .gs_w li { padding: 0 10px; }
    </style>
</head>
<body>
    <div id="board-content">
        <div class="gridster responsive-column-width">
            <section class="gs_w">
                <ul>
                    <li>Board</li>
                    <?php foreach($freeboard->getBoardList() as $board): ?>
                        <li>
                            <a
                                href="/detail.php?board=<?php echo $board['file'] ?>"
                                style="">
                                <?php echo $board['name'] ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </section>
        </div>
    </div>
</body>
</html>