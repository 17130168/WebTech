<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="3b.css">
</head>
<script>
    $(function () {
		<?php echo 'var newsId = '.$_GET['newsId'].';' ?>      

        $('form').submit(function (e) {

            let $form = $(this);
            let comment = {
                name: $form.children('input[name="name"]').val(),
                text: $form.children('textarea[name="text"]').val(),
                email: $form.children('input[name="email"]').val(),
                newsId: newsId
            };

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                dataType: 'json',
                data: { data: comment },
                success: function (message) {
                    alert(message);
                }
            }).fail(function (data) {
                alert("error: ", data);
            });
            e.preventDefault();
        });

        $.ajax({
            url: 'getdata_3b.php',
            method: 'get',
            dataType: 'json',
            data: { newsId },
            success: comments => AddComments(comments)
        });
		
		function AddComments(comments) {
		if (comments != null) {
			for (let i = 0; i < comments.length; i++) {
				let newComment = 
				'<div class="comment">' +
					'<img src="images/ava.jpg"></img>' +
					'<div class="comment-content">' +
						'<p class="author">Автор: ' + comments[i].Name + '</p>' +
						'<p class="date">' + comments[i].DateTime + '</p>' +
						'<p class="text">' + comments[i].Text + '</p>' +
					'</div>' +
				'</div>';

				$('.comments-container').append(newComment)
			}
		}
	}
    });
</script>

<body>
    <div class="content">
	<h1>Новость:</h1>
	<?php echo '<p>'.$_GET['text'].'</p>' ?> 
        <h2>Комментарии:</h2>
        <hr />
        <div class="comments-container"></div>
        <h3>Оставьте свой комментарий:</h3>
        <form method="POST" action="setdata_3b.php">
            <label for="name">Текст:</label><br>
            <textarea class="input" name="text"></textarea></br>
            <label for="name">Ваше имя:</label><br>
            <input class="input" type="text" name="name" /><br>
            <label for="name">Ваш Email:</label><br>
            <input class="input" type="text" name="email" /><br>
            <button class="button" type="submit">Добавить комментарий</button><br>
        </form>
    </div>
</body>

</html>