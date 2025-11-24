@extends('layouts.app')

@section('content')
    <div id="filter" class="bg-light shadow-lg position-fixed top-0 start-0 h-100 p-3">
        <div class="d-flex align-items-center">
            <h2 class="m-0">Filter vacaturen</h2>
            <button id="closeFilter"
                    class="btn btn-danger rounded ms-auto d-flex justify-content-center align-items-center">x
            </button>
        </div>
        <form action="{{ route('home.index') }}" class="p-2" method="get">
            <div>
                <label class="form-label">Skills:</label>
                <select name="skills[]" class="form-select" multiple>
                    @foreach ($allSkills as $skill)
                        <option value="{{ $skill->skill}}"
                                @if (in_array($skill->skill, $filteredSkills ?? [])) selected @endif>
                            {{ $skill->skill }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Gewenste salaris p/m</label>
                <input class="form-control" type="number" step="0.01" name="expectedSalary"
                       value="{{ request('expectedSalary') }}">
            </div>
            <br>
            <button class="btn btn-success w-100 d-flex align-items-center justify-content-center">Zoek</button>
        </form>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div>
                @if (empty($vacancies))
                    Er zijn hier nog geen vacatures.
                @else
                    @auth
                        <button id="filterButton"
                                class="btn border border-secondary shadow-sm rounded-pill position-fixed z-3 bg-light">
                            <i class="fa fa-sort"></i> Filter
                        </button>
                        <br>
                        <div class="auth_dashboard_content">
                            <div class="open_vacancies">
                                <h4><b>Openstaande Vacatures</b></h4>
                                @foreach ($vacancies as $vacancy)
                                    <a href="{{ route('vacatures.kandidaatlinken', $vacancy->id) }}" class="btn btn-outline-success mt-2">
                                        Kandidaat koppelen
                                    </a>
                                
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="title" style="color: red"><b>{{ $vacancy->jobTitle }}</b>
                                                </h4>
                                                <h5><b>{{ $vacancy->employer->companyAddress }}</b>
                                                    • {{ $vacancy->employer->companyName }}
                                                    • {{ $vacancy->jobTitle }}</h5>
                                                <span class="information_block">30 - 40 uur</span>
                                                <span class="information_block">&euro; {{ $vacancy->salary }} p/m</span>
                                                <span class="information_block">Ploegen</span>
                                                <span class="information_block">Winstdeling</span>
                                                <br>
                                                @foreach($vacancy->skills()->get() as $skill)
                                                    <span class="information_block"
                                                          style="background-color: #FFF0F0;">{{$skill->skill}}</span>
                                                @endforeach
                                                <div style="margin-top: 20px;">
                                                    <small
                                                        class="small_text">{{ ($vacancy->created_at)->diffForHumans(new DateTime()) }}
                                                        geleden</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="dashboard_content">
                            <div class="left_content" id="left_content">
                                <p><b>{{ count($vacancies) }} Vacatures gevonden</b></p>
                                <small>Op XXX.nl vind je een groot aanbod van vacatures in heel Nederland. Solliciteer
                                    nu hier naar jouw droombaan.</small>
                                @foreach ($vacancies as $vacancy)
                                    <a href="?vacancy={{ $vacancy->id }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="title" style="color: red"><b>{{ $vacancy->jobTitle }}</b>
                                                </h4>
                                                <h5><b>{{ $vacancy->employer->companyAddress }}</b>
                                                    • {{ $vacancy->employer->companyName }}
                                                    • {{ $vacancy->jobTitle }}</h5>
                                                <span class="information_block">30 - 40 uur</span>
                                                <span class="information_block">&euro; {{ $vacancy->salary }} p/m</span>
                                                <span class="information_block">Ploegen</span>
                                                <span class="information_block">Winstdeling</span>
                                                <br>
                                                @foreach($vacancy->skills()->get() as $skill)
                                                    <span class="information_block"
                                                          style="background-color: #FFF0F0;">{{$skill->skill}}</span>
                                                @endforeach
                                                <div style="margin-top: 20px;">
                                                    <small
                                                        class="small_text">{{ ($vacancy->created_at)->diffForHumans(new DateTime()) }}
                                                        geleden</small>
                                                </div>
                                                @if (isset($_GET['vacancy']) && $_GET['vacancy'] == $vacancy->id)
                                                    <div class="active_arrow_border"></div>
                                                    <div class="active_arrow"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="right_content" id="right_content">
                                @if (!isset($_GET['vacancy']))
                                    <div class="card jobmail" id="jobmail">
                                        <h4>Welkom! Log <b>hier</b> in op uw <b>account</b></h4>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <label for="email"><b>Je e-mail</b></label><br>
                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email" value="{{ old('email') }}" required
                                                   autocomplete="email">

                                            <label for="password"><b>Wachtwoord</b></label><br>
                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="current-password">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Kan je account niet vinden, of onjuist wachtwoord' }}</strong>
                            </span>
                                            @enderror

                                            <div><input type="submit" value="Inloggen"/></div>

                                            <p class="small_text">(Wachtwoord vergeten? Klik <a
                                                    href="{{ route('password.request') }}"><u>hier</u></a> om het te
                                                herstellen.)</p>
                                        </form>
                                    </div>
                                @else
                                    <div class="card vacancy_detail">
                                        <div class="vacancy_header">
                                            <h4 class="title" style="color: red">
                                                <b>{{ $selected_vacancy->jobTitle }}</b></h4>
                                            <h5><b>{{ $selected_vacancy->employer->companyAddress }}</b>
                                                • {{ $selected_vacancy->employer->companyName }}
                                                • {{ $selected_vacancy->jobTitle }}</h5>
                                        </div>
                                        <a href="{{ url('/') }}" class="close_button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                <path
                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                            </svg>
                                        </a>
                                        <div class="vacancy_content" id="vacancy_content">
                                            <div class="vacancy_image">
                                                <img
                                                    src="https://www.uitzendbureausalland.nl/media/14yfpxld/adende.jpg?anchor=center&mode=crop&rnd=133014223295570000"
                                                    alt="hier is logo" class="vacancy_logo"/>
                                            </div>

                                            <div class="vacancy_info">
                                                <div class="vacancy_row">
                                                    <ul>
                                                        <li><b>Gevraagd</b></li>
                                                        @foreach ($skills as $skill)
                                                            <li>{{ $skill->skill }}</li>
                                                        @endforeach
                                                    </ul>
                                                    <ul>
                                                        <li><b>Aanbod</b></li>
                                                        <li>&euro; {{ $selected_vacancy->salary }} (bruto)</li>
                                                        <li>Gratis lunch</li>
                                                        <li>Heerlijke applesap</li>
                                                    </ul>
                                                </div>

                                                <div class="vacancy_description">
                                                    <h5><b>Vacature in het kort</b></h5>
                                                    <div class="vacancy_location">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-geo-alt"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                                                            <path
                                                                d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                                        </svg>
                                                        Utrecht
                                                    </div>
                                                    <p>{{ $selected_vacancy->jobDescription }}</p>
                                                </div>

                                                <div class="vacancy_campany_info">
                                                    <h5><b>Over het bedrijf</b></h5>
                                                    <p>Open sinds XXXX, {{ $vacancy->employer->totalEmployees }}+
                                                        medewerker<br>Website: <a
                                                            href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">www.CornHub.com</a>
                                                    </p>
                                                </div>

                                                <div class="vacancy_readmore">
                                                    <h5><b>Volledige vacaturetekst</b></h5>
                                                    <p>
                                                        We're no strangers to love<br>
                                                        You know the rules and so do I<br>
                                                        A full commitment's what I'm thinkin' of<br>
                                                        You wouldn't get this from any other guy<br>
                                                        <br>
                                                        I just wanna tell you how I'm feeling<br>
                                                        Gotta make you understand<br>
                                                        <br>
                                                        Never gonna give you up, never gonna let you down<br>
                                                        Never gonna run around and desert you<br>
                                                        Never gonna make you cry, never gonna say goodbye<br>
                                                        Never gonna tell a lie and hurt you<br>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </div>
@endsection

<script>
    const url = window.location.search;
    const params = new URLSearchParams(url);
    const vacancy = params.get('vacancy');

    window.addEventListener('load', function () {
        if (vacancy != null) {
            window.scrollTo(0, 95 + (192.5 * (vacancy - 1)));
            document.getElementById('right_content').style = "width: 60%;"

            //mobiel layout
            if (window.innerWidth <= 768) {
                window.scrollTo(0, 0);
                document.getElementById('left_content').style = "display: none;"
                document.getElementById('right_content').style = "display: flex; width: 100%; overflow: hidden;"
            }
        }

        const filterButton = document.getElementById('filterButton');
        const filter = document.getElementById('filter');
        const closeFilter = document.getElementById('closeFilter');

        filterButton.addEventListener('click', function () {
            const positionX = filter.getBoundingClientRect().left;
            if (positionX !== 0) {
                filter.style.transform = "translateX(0px)";
            }
        });

        closeFilter.addEventListener('click', function () {
            const positionX = filter.getBoundingClientRect().left;
            if (positionX === 0) {
                filter.style.transform = "translateX(-1000px)";
            }
        });
    });
</script>
