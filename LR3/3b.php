<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="3b.css">
</head>
<script>
    $(function () {
		<?php echo 'var newsId = '.$_GET['newsId'].';' ?>      

		function AddComment(comment)
		{		
			let commentDateTime = new Date(comment.DateTime);
			let commentRusDate = commentDateTime.toLocaleDateString("ru-RU") + " " + commentDateTime.getHours() + ":" + commentDateTime.getMinutes() + ":" + commentDateTime.getSeconds();
			let content = '<div class="comment">' +
			'<img src="images/ava.jpg"></img>' +
				'<div class="comment-content">' +
					'<p class="author">Автор: ' + comment.Name + '</p>' +
					'<p class="date">' + commentRusDate + '</p>' +
					'<p class="text">' + comment.Text + '</p>' +
				'</div>' +
			'</div>';
			$('.comments-container').prepend(content)
		}
		
        $('form').submit(function (e) {

            let $form = $(this);
            let comment = {
                Name: $form.children('input[name="name"]').val(),
                Text: $form.children('textarea[name="text"]').val(),
                Email: $form.children('input[name="email"]').val(),
				DateTime: new Date(),
                NewsId: newsId
            };

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                dataType: 'json',
                data: { data: comment },
                success: function (message) {	
					$('form').find("input[type=text], textarea").val("");				
					AddComment(comment);
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
				AddComment(comments[i])				
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