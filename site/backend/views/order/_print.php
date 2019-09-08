<style>

body * {
    font-family: Arial, Helvetica, sans-serif;
}

</style>

<style type="text/css" media="print">
button {display: none; }
</style>

<?= $this->render('../../../common/mail/order', ['model' => $model]) ?>

<br>
<br>
<br>
<button data-role="print" style="font-family: arial;">Напечатать</button>

<script>

document.querySelector('[data-role="print"]').addEventListener('click', function () {
    window.print();
});

window.onload = function () {
    window.print();
}

</script>