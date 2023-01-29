function myFunction() {
    var input, filter, ul, li, a, i, txtValue, p, sum;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myDiv");
    li = ul.getElementsByClassName('shop-block');
    p=document.getElementById('text-results')
    sum=0
    for (i = 0; i < li.length; i++) {
        
        a = li[i].getElementsByTagName("h5")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            sum=sum+1
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
    p.innerHTML=(`${sum} de 3 resultados`)
}
