let basket = {
    el: document.querySelector('.basket span'),
    load(){
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/handlers/basket_handler.php`);
        xhr.send();
        
        xhr.addEventListener('load', ()=>{
            let data = JSON.parse(xhr.responseText);

            this.el.innerHTML = data.basket.count;
        });
    }
}

basket.load();