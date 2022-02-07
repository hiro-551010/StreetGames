@extends('users.header')
@section('header')

<main class="home">
  <div class="home_header">
      <h1 class="">Street Games</h1>
  </div>

  <div class="home_inner">
    <section class="home_news home_section">
      <h2>NEWS</h2>

      <ol class="home_news-lists home_section-lists">
        <li>
          <a href=""><span>2022.2.20</span><span>タイトルが入ります。</span></a>
        </li>
        <li>
          <a href=""><span>2022.2.20</span><span>タイトルが入ります。長いタイトルタイトルが入ります。長いタイトルタイトルが入ります。長いタイトルタイトルが入ります。</span></a>
        </li>
        <li>
          <a href=""><span>2022.2.20</span><span>タイトルが入ります。</span></a>
        </li>
      </ol>

      <div class="home_pagination">
        <ol class="pagination">
          <li class="page-item">
            <a href="" class="page-link"><</a>
          </li>
          <li class="page-item">
            <a href="" class="page-link">1</a>
          </li>
          <li class="page-item">
            <a href="" class="page-link">2</a>
          </li>
          <li class="page-item">
            <a href="" class="page-link">></a>
          </li>
        </ol>
      </div>
    </section>
  </div>

</main>

@endsection