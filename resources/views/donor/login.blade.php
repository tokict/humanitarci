@extends('layouts.full')

@section('content')
            <!-- Section -->
            <section class="small-section">
                <div class="container relative">
                    
                    <div class="row">
                        
                        <!-- Content -->
                        <div class="col-sm-8">
                            
                            <!-- Post -->
                            <div class="blog-item">
                                
                                <!-- Post Title -->
                                <h2 class="blog-item-title font-alt"><a href="blog-single-sidebar-right.html">{{$campaign->beneficiary->name}}</a></h2>
                                
                                <!-- Author, Categories, Comments -->
                                <div class="blog-item-data">
                                    <a href="#"><i class="fa fa-clock-o"></i> {{$campaign->created_at}}.</a>
                                    <span class="separator">&nbsp;</span>
                                    <a href="#"><i class="fa fa-map-marker"></i> {{$campaign->beneficiary->person->city->name}}, {{$campaign->beneficiary->person->city->region->name}}</a>
                                    <span class="separator">&nbsp;</span>
                                    <i class="fa fa-folder-open"></i>
                                    <a href="">Smještaj</a>
                                </div>
                                
                                <!-- Media Gallery -->
                                <div class="blog-media">
                                    <ul class="clearlist content-slider">
                                        @if(unserialize($campaign->media_info))
                                        @foreach( unserialize($campaign->media_info) as $media)
                                        <li>
                                            <img src="{{$media->getPath('small')}}" alt="" />
                                        </li>
                                            @endforeach
                                            @endif
                                    </ul>
                                </div>
                                
                                <!-- Text Intro -->
                                <div class="blog-item-body">

<p>
    <btn class="btn-mod btn-circle bg-facebook"><i class="fa fa-facebook"></i> Share</btn>
    <btn class="btn-mod btn-circle"><i class="fa fa-twitter"></i> Tweet</btn>
</p>

<p>Lucija Krstić iz triljskog naselja Vojnića ima deset godina i učenica je četvrtog razreda Osnovne škole "Trilj". S majkom Marijom živi u trošnoj kućici, zapravo u nečemu što se kućicom teško može nazvati.</p>

Priča o toj djevojčici objavljena u popularnoj emisiji jedne komercijalne TV kuće još jednom je pogodila "u sridu" i digla na noge ljude dobrog srca. Reporteri "Slobodne" u petak poslijepodne bili su u Vojniću, <p>razgovarali su s djevojčicom Lucijom i njezinom majkom Marijom, a tu smo zatekli i Lucijina učitelja Milana Sarića, koji je toj obitelji među prvima pritekao u pomoć.</p>

<p>I VI MOŽETE POMOĆI Tužna sudbina male Triljanke zapalila društvene mreže: živi u strašnim uvjetima, a sve što želi je stol na kojem može pisati domaći rad</p>

<p>Priča je preko TV ekrana stigla do šire javnosti poslije proslave jednog rođendana u jednoj sinjskoj igraonici. O tome događaju Lucija kaže:</p>

– Bila sam na rođendanu moje najbolje prijateljice Magdalene. Zaboravila sam obući čarape. To je zapazila jedna teta i objavila na Facebooku, a napisala je i pismo televiziji. Oni su došli i snimili moju mamu, mene i moga učitelja.
– Kako si zaboravila obući čarape? Jesi li ih imala?
– Imala sam ih, ali u žurbi sam jednostavno zaboravila.
– Pa, zaboravljaš li inače?
– Ne.
– Kakva si učenica?
– Onako. Ja mislim dobra.
– S kakvim si uspjehom prošla dosadašnje razrede?
– Prvi i drugi s vrlo dobrim, a treći razred s dobrim uspjehom.
– Zašto nisi bolje učila?
– Previše sam se igrala, eto zato.
– Kako se prema tebi odnose drugi učenici?
– Odlično. Sa svima sam prijatelj. Svi me podržavaju.
– Ruga li ti se itko?
– Ne, nitko mi se u razredu nije rugao.
– Znaju li tvoji prijatelji iz razreda da živiš s majkom u teškim uvjetima?
<p>– Dakako da znaju.</p>

<p>Inače, Lucijin otac umro je prije osam i pol godina. O tome njegova udovica Marija kaže:</p>

– Moj pokojni muž bio je psihički bolesnik, a uz to je prekomjerno konzumirao alkohol. Sud ga je 2008. godine prisilno uputio na liječenje u specijaliziranu zdravstvenu ustanovu na Rabu. Kada se vratio s Raba 21. lipnja 2008. godine, otišao je od kuće u nepoznatom smjeru. Desetak dana poslije, 2. srpnja, našli su ga mrtvog u bunaru. Lucija je tada imala godinu i pol dana. Od tada nas dvije živimo same.
– Od čega živite?
– Ja sam nezaposlena. Imamo obiteljsku mirovinu moga pokojnog muža od 1700 kuna, tuđu njegu i pomoć 500 kuna i dječji doplatak 280 kuna.
– Imate, dakle, mjesečna primanja od 2500 kuna. Možete li s tim živjeti?
<p>– Moglo bi se s tim živjeti da se ima krov nad glavom, da imamo bar minimalne uvjete u ovoj dotrajaloj građevini koju mi nazivamo kućom – kaže Marija i vodi nas pokazati gdje to ona i Lucija žive.</p>

<p>Kamena kuća izvana i ne izgleda baš tako loše. Ali kada se uđe u kuću, vidi se i osjeća jad i tuga. Pod od drvenih dasaka između kojih se vidi.</p>

<p>– Ovo je sada odlično. Mi smo postavili nove daske. Kroz prijašnji pod Lucija je znala propasti – objašnjava učitelj Milan.</p>

<p>Cijela "kuća" je jedna prostorija. Umjesto čvrstih pregrada, postavljena je nekakva deka.</p>

<p>– Grijemo samo ovaj dio pa sam ogradila da ne bježi toplina. Ovdje kuhamo, jedemo i spavamo – veli Marija.</p>

Na stropu pogled privlače čađave drvene grede, iznad kojih je također tavan od dasaka. Kuća je spojena na elektromrežu, a jedina blagodat od toga je, čini se, rasvjeta. Jer u kući nismo primijetili ni jedan <p>električni kućanski aparat, na primjer televizor, električni štednjak, hladnjak i slično.</p>

– Najteže mi je što u kući nemamo kupatilo. Nemamo ni vode – nabraja Marija.
– Pa kako se kupate, kako kupate Luciju?
<p>– Na štednjaku na drva ugrijem vode i Luciju okupam u plastičnom maštelu.</p>

<p>Kako u Vojniću nema škole, sva djeca iz toga sela putuju do škole u Trilju. Među njima je i Lucija. Koja je do prije godinu dana s majkom pješačila do škole i natrag kući. O tome njezina majka kaže:</p>

– Dok nije bilo autobusa, ja sam Luciju svako jutro morala pješice voditi do četiri kilometra udaljenog Trilja. Kad bih je ostavila u školi, vratila bih se kući, a onda ponovno pješačila do Trilja kako bih je <p>dovela iz škole kući.</p>

<p>Pitamo čime su do škole putovala druga djeca.</p>

– Drugi su – nastavlja Marija – putovali osobnim automobilom. Majka jednog djeteta rekla mi je, ako ja hoću da ona vozi moju Luciju, da joj moram platiti tristo kuna mjesečno. Kad sam vidjela da nema druge, davala <p>sam joj taj novac pa nam je znalo manjkati za kruh. Hvala Bogu, prošle godine počeo je voziti autobus pa se sada vozi besplatno.</p>

<p>– Je li vam tko do sada pomogao?
– Najviše učitelj Milan Sarić. Kad je Luciji bila pričest, donio je svega. On nam je postavio daske na podu i tavanu, a donio je i materijal za krov.
– Nadate li se da će vam sada, kada je najšira javnost saznala u kakvim uvjetima živi Lucija, netko ipak pomoći?
– Dakako da se nadam. Već su počele stizati donacije u odjeći, hrani, igračkama i nešto novca.
– Vidim da se ne odvajate od psa?
– To je bio pas lutalica. Uhvatio ga je Lucijin stric Ivica i darovao joj ga je za rođendan.
– To su još jedna usta u kući. I pas mora jesti?
– Tako je, ali dobili smo veću količinu hrane za pse pa mu imamo što davati.</p>

<p>Učitelj Milan Sarić je, kaže, za teški materijalni položaj svoje učenice Lucije doznao prije dvije godine.</p>

– Moje dvije kolegice su ih obišle i ispričale mi u kakvim uvjetima žive Lucija i njezina majka. Ja sam odlučio da nešto treba napraviti kako bi se stanje mijenjalo. Uz pomoć prijatelja i radnih kolega te Udruge žena "Triljanke" učinili smo koliko smo mogli. Vjerujem da će se sada, kada je najšira javnost saznala o njihovim teškim životnim uvjetima, cijela priča sretno okončati i da će Lucija i njezina majka dobiti barem minimalne uvjete za život dostojan ljudi – kaže učitelj Sarić.                                </div>
                                
                            </div>
                            <!-- End Post -->
                            
                        </div>
                        <!-- End Content -->

                        @include('sections.campaign_sidebar')
                    </div>
                    
                </div>
            </section>
            <!-- End Section -->
@endsection
