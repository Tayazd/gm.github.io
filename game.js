  window.addEventListener('scroll', function() {
            const sidebar = document.querySelector('.sidebar');
            if (window.scrollY > 100) {
                sidebar.style.transform = 'translateY(20px)';
                sidebar.style.opacity = '0.9';
            } else {
                sidebar.style.transform = 'translateY(0)';
                sidebar.style.opacity = '1';
            }
        });
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
        const pageBtns = document.querySelectorAll('.page-btn');
        pageBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                pageBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });

        