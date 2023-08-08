const $html = document.querySelector('html')
const $checkbox = document.querySelector('#dn')

$checkbox.addEventListener('change', function () {
    $html.classList.toggle('white-mode')

})

const estrela2 = document.getElementById('star2');
const checkbox = document.getElementById('dn');
const div = document.getElementById('content');

checkbox.addEventListener('click', function () {
    if (checkbox.checked) {
        div.style.display = 'none';
        estrela2.style.display = 'block';
    } else {
        div.style.display = 'block';
        estrela2.style.display = 'none';
    }
});

const list = document.querySelectorAll('.list');
function activeLink(){
    list.forEach((item)=>
    item.classList.remove('active'));
    this.classList.add('active');
}
list.forEach((item) =>
item.addEventListener('click',activeLink));