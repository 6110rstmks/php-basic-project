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

    // ページャー用のjs
    const comment_pager_form = document.querySelector('.comment-pager-form')
    const prev_button = document.querySelector('.prev-button')
    const next_button = document.querySelector('.next-button')

    prev_button.addEventListener('click', () => {
        prev_button.parentElement.submit();
    })

    if (next_button)
    {
        next_button.addEventListener('click', () => {
            next_button.parentElement.submit();
        })
    }
