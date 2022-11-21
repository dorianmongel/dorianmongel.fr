window.onload = (event) => {
    var msnry = new Masonry( ".grid", {itemSelector: "article", gutter: 30});
};

document.getElementById("search").addEventListener("keyup", searchFunction)

function searchFunction(e) {
    let searchWord = document.getElementById("search").value.toLowerCase().replace("#", "");
    if( searchWord.length > 2){
        let articles = document.querySelectorAll('article');
        for (let article of articles) {
            article.style.opacity = ".2";
            let lis = article.querySelectorAll('.content > ul > li');
            for (let li of lis) {
                let tag = li.innerHTML.replace("#", "");
                if( tag.substring(0, searchWord.length).toLowerCase() == searchWord ){
                    article.style.opacity = "1";
                }
            }
        }
    }else{
        let articles = document.querySelectorAll('article');
        for (let article of articles) {
            article.style.opacity = "1";
        }

    }
}