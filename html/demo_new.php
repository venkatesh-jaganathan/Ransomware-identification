<form id="my-form" action="hello.php">
    <input type="text" name="in" value="some data" />
    <button type="submit">Go</button>
</form>
<script>

window.onload=function() {
    document.getElementById('my-form').onsubmit=function() {
    /* do what you want with the form */
    
    // Should be triggered on form submit
    alert('test');
    alert(document.getElementById('my-form').action);
    // You must return false to prevent the default form behavior
    return false;
  }
}
</script>