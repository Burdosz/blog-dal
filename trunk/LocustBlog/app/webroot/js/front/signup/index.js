/**
 * メールの入力をチェックする
 */
function checkEmail() {
    var email = document.getElementById('email').value;
    
    if (email) {
        document.getElementById('form').submit();
    } else {
        alert('メールアドレスが未入力です');
    }
}