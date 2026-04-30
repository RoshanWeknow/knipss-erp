<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
      crossorigin="anonymous"
    />
   <style>
        *{
            margin:0;
            padding:0;
        }
        .top-bar {
            background: #333;
            color: #fff;
            padding: 1rem;
        }

        .btn {
            background: coral;
            color: #fff;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 0.7rem 2rem;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .page-info {
            margin-left: 1rem;
        }

        .error {
            background: orangered;
            color: #fff;
            padding: 1rem;
        }

        @media print{
            *{
                display:none;
            }
        }

   </style>
    <title>PDF Viewer</title>
  </head>
  <script>
    // Disable right-click context menu
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });

    // Disable keyboard shortcuts for save (Ctrl+S or Command+S)
    window.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
            e.preventDefault();
            alert("Downloading is disabled for this document.");
        }
    });

  </script>
  <body>
    <div class="top-bar">
      <button class="btn" id="prev-page">
        <i class="fas fa-arrow-circle-left"></i> Prev Page
      </button>
      <button class="btn" id="next-page">
        Next Page <i class="fas fa-arrow-circle-right"></i>
      </button>
      <span class="page-info">
        Page <span id="page-num"></span> of <span id="page-count"></span>
      </span>
    </div>

    <canvas id="pdf-render"></canvas>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js" integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const url = '<?php echo $_POST['pdf_path'];?>';

        let pdfDoc = null,
          pageNum = 1,
          pageIsRendering = false,
          pageNumIsPending = null;

        const scale = 1.2; // Adjust the scale factor here
        const canvas = document.querySelector('#pdf-render');
        const ctx = canvas.getContext('2d');

        const renderPage = num => {
          pageIsRendering = true;
          pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            const renderCtx = {
              canvasContext: ctx,
              viewport
            };
            page.render(renderCtx).promise.then(() => {
              pageIsRendering = false;
              if (pageNumIsPending !== null) {
                renderPage(pageNumIsPending);
                pageNumIsPending = null;
              }
            });
            document.querySelector('#page-num').textContent = num;
          });
        };

        const queueRenderPage = num => {
          if (pageIsRendering) {
            pageNumIsPending = num;
          } else {
            renderPage(num);
          }
        };

        const showPrevPage = () => {
          if (pageNum <= 1) {
            return;
          }
          pageNum--;
          queueRenderPage(pageNum);
        };

        const showNextPage = () => {
          if (pageNum >= pdfDoc.numPages) {
            return;
          }
          pageNum++;
          queueRenderPage(pageNum);
        };

        pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
          pdfDoc = pdfDoc_;
          document.querySelector('#page-count').textContent = pdfDoc.numPages;
          renderPage(pageNum);
        }).catch(err => {
          const div = document.createElement('div');
          div.className = 'error';
          div.appendChild(document.createTextNode(err.message));
          document.querySelector('body').insertBefore(div, canvas);
          document.querySelector('.top-bar').style.display = 'none';
        });

        document.querySelector('#prev-page').addEventListener('click', showPrevPage);
        document.querySelector('#next-page').addEventListener('click', showNextPage);

    </script>
  </body>
</html>