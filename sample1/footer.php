</div>
<footer class="foot">
	<div class="foot_in">
		<span class="foot_a">
			<a href="./index.php" class="foot_a_in">TOP</a>
			<a href="./system.php" class="foot_a_in">SYSTEM</a>
			<a href="./cast.php" class="foot_a_in">CAST</a>
			<a href="./schedule.php" class="foot_a_in">SCHEDULE</a>
			<a href="./castblog.php" class="foot_a_in">BLOG</a>
			<a href="./access.php" class="foot_a_in">ACCESS</a>
			<a href="./recruit.php" class="foot_a_in">RECRUIT</a>
		</span><br>
		<span class="foot_b">
		<?if($admin_config["webp_select"] == 1){?>
			<img src="./img/page/logo/logo_450.webp?t=<?=time()?>" class="foot_logo"><br>
		<?}else{?>
			<img src="./img/page/logo/logo_450.png?t=<?=time()?>" class="foot_logo"><br>
		<?}?>
			<a href="./policy.php" class="foot_c_in">プライバシーポリシー</a>
		</span><br>
	</div>

	<div class="signet">copyright 2020 Night Party all right reserved.</div>
	<div class="to_top">
		<div class="to_top_in"></div>
		<div class="to_top_in2"></div>
	</div>
</footer>
</body>
</html>
