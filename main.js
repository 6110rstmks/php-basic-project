    // いいねクリック処理
    const likes = document.querySelectorAll('.like')


    likes.forEach(like => {

        if (like)
        { 
            like.addEventListener('click', (e) => {
                console.log(e.target)
                // e.target.stopPropagation()
    
                // いいねをクリックしたらフォームを送信
                e.target.parentElement.submit()
            })

        }
    })
