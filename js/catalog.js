class Product{
    constructor(name, price, photo, id){
        this.name = name; 
        this.price = price;
        this.photo = photo; 
        this.id  = id; 
    }
    show(){
        alert(`${this.name} ${this.price} ${this.photo}`);
    }
    render(parentEl){
        let productItem = document.createElement('a');
        productItem.href = `/product.php?id=${this.id}`;
        productItem.classList.add('catalog-products-item');
        productItem.innerHTML = `
            <img src='${this.photo}'>
            <h2>${this.name}</h2>
            <p>${this.price} руб.</p>
        `;

        parentEl.appendChild(productItem);
    }
}

class Catalog{
    constructor(){
        this.el = document.querySelector('.catalog');
        this.section = this.el.getAttribute('data-section');
        this.products = [];
        this.filters = {
            price:[
                [0, 1000],
                [1000, 2000],
                [2000, 3500],
                [3500, 5000],
                [5000, 20000]
            ],
            activePrice: null
        };

        this.renderFilterPrice();
    }
    addProducts( productsArray ){
        productsArray.forEach((product)=>{
            this.products.push( product );
        });
    }
    renderFilterPrice(){
        let select = document.createElement('select');
        select.name = 'filter-price';

        this.filters.price.forEach((priceArr)=>{
            let option = document.createElement('option');
            option.innerHTML = `${priceArr[0]}-${priceArr[1]} руб.`;
            option.value = `${priceArr[0]}-${priceArr[1]}`;

            select.appendChild(option);
        });

        let that = this;

        select.addEventListener('change', function(){
            that.filters.activePrice = this.value;
            that.load();
        });

        this.el.querySelector('.catalog-filters').appendChild(select);
    }
    render(){
        let catalogProductsBox = this.el.querySelector('.catalog-products');
        catalogProductsBox.innerHTML = '';
        this.products.forEach((product)=>{
            product.render(catalogProductsBox);
        });
    }
    preloadOn(){
        this.el.classList.add('preload');
        //Необходимо метод скрытия и показа реализовать через добавление
        //класса (css) к элементу .catalog
        //этот класс должен работать на измении opacity
    }
    preloadOff(){
        this.el.classList.remove('preload');
    }
    paginationRender(paginationConfig){
        let paginationEl = this.el.querySelector('.catalog-pagination');
        paginationEl.innerHTML = '';
        
        for( let i = 1; i <= paginationConfig.countPage; i++ ){
            let div = document.createElement('div');
            div.classList.add('catalog-pagination-item');

            if( i == paginationConfig.nowPage ){
                div.classList.add('active');
            }
            div.innerHTML = i;
            div.setAttribute('data-page-id', i);

            let that = this;
            div.addEventListener('click', function(){
                let pageNum = this.getAttribute('data-page-id');

                that.load(pageNum);
            });

            paginationEl.appendChild( div );
        }
    }
    load(page = 1){
        this.preloadOn();
    
        //Тут должен быть ajax-запрос на получениие данных о карточках из БД
        //Запрос должен идти на файл /handlers/catalog_handler.php
        //Получамем от бекенда формат json
        //Создаем и заполняем массив this.products
        //И рендерим его

        let xhr = new XMLHttpRequest();
        let path = `/handlers/catalog_handler.php?page=${page}&section=${this.section}`;

        if( this.filters.activePrice != null ){
            path += `&filter_price=${this.filters.activePrice}`
        }

        xhr.open('GET', path);
        xhr.send();
        //Тут необходимо написать методы xhr.open() xhr.send()
        xhr.addEventListener('load', ()=>{
            let data = JSON.parse(xhr.responseText);
            this.paginationRender( data.pagination );
            
            this.products = [];
            data.products.forEach((productItem)=>{
                this.products.push( new Product(productItem.name, productItem.price,
                    productItem.img_src, productItem.id) );
            })
            //Тут пойдет код заполнения массива this.products

            this.render();
            this.preloadOff();
        });
    }
}

let catalog = new Catalog();
catalog.load();