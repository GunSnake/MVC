<html>
<body>
<?php echo $this->value['data']; ?>, <?php echo $this->value['person']; ?>
<ul>
    <?php foreach ((array)$this->value['b'] as $k => $v) { ?>
    <li><?php echo $v; ?></li>
    <?php } ?>
</ul>
&lt;?php
echo $pai*2;
?&gt;
<?php if ($data == 'abc') { ?>
abc
<?php }else if ($data == 'aaa'){ ?>
aaa
<?php }else{ ?>
it's me
<?php } ?>


<a href="http://www.baidu.com">百度</a>
</body>
</html>