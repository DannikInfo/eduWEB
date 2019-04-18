<?
require_once('../../header.php');
if(isset($_SESSION['login']) && $_SESSION['login']){?>
		<h1 class="text-center">Посещаемость</h1>
		<div class="wrapper navfix">
			<?
				require_once './handler.php';
				visits($_SESSION['id'], $_SESSION['group']);
			?>
			<div class="searchResult"></div>
		</div>
<?}else{?>
	<script type="text/javascript">window.location.href = "/";</script>
<?}?>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
		   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
		   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		   ym(52974043, "init", {
		        clickmap:true,
		        trackLinks:true,
		        accurateTrackBounce:true
		   });
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/52974043" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	    <script src="files/system/js/bootstrap.min.js"></script>
    </body>
</html>