@extends('esport.layouts.app')

@section('content')
<div class="bg-black text-white overflow-x-hidden">
  {{-- Matrix Rain Background --}}
  <div id="matrix-bg" class="fixed inset-0 z-0 opacity-20 pointer-events-none"></div>

  {{-- Particle System --}}
  <div id="particle-container" class="fixed inset-0 z-10 pointer-events-none"></div>

  {{-- Mouse Follower --}}
  <div id="mouse-follower" class="fixed w-4 h-4 bg-purple-500 rounded-full pointer-events-none z-50 transition-transform duration-100 ease-out opacity-50"></div>

  {{-- HERO --}}
  <section class="relative min-h-screen interactive-bg">
    {{-- Gradient overlays & floating blobs --}}
    <div class="absolute inset-0">
      <div class="absolute inset-0 bg-gradient-to-br from-purple-900/80 via-blue-900/60 to-black/80 z-10"></div>
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(168,85,247,0.1)_0%,transparent_50%)]"></div>

      {{-- Floating glow elements --}}
      <div class="absolute inset-0">
        <div class="absolute animate-float-slow parallax-element" style="top:10%;left:5%;" data-speed="0.5">
          <div class="w-32 h-32 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mix-blend-multiply blur-xl opacity-30 animate-pulse-glow"></div>
        </div>
        <div class="absolute animate-float-medium parallax-element" style="top:50%;right:15%;" data-speed="0.3">
          <div class="w-40 h-40 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mix-blend-multiply blur-xl opacity-30 animate-pulse-glow"></div>
        </div>
        <div class="absolute animate-float-fast parallax-element" style="bottom:20%;left:25%;" data-speed="0.7">
          <div class="w-24 h-24 bg-gradient-to-r from-red-500 to-orange-500 rounded-full mix-blend-multiply blur-xl opacity-30 animate-pulse-glow"></div>
        </div>
      </div>
    </div>

    <div class="relative z-20 min-h-screen flex items-center justify-center">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16 opacity-0 animate-fade-in-up max-w-4xl mx-auto" id="hero-content">
          <h1 class="text-5xl md:text-7xl font-black text-white mb-8 leading-tight">
            Welcome to M-GEN
            <span class="relative">
              <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-purple-500 to-blue-500 animate-gradient-text animate-neon-flicker">
                <span id="typing-text" class="typing-text"></span>
              </span>
              <span class="absolute -inset-1 bg-gradient-to-r from-red-500 via-purple-500 to-blue-500 opacity-30 blur-lg -z-10 animate-pulse"></span>
            </span>
          </h1>
          <p class="text-xl md:text-2xl text-gray-300 max-w-2xl mx-auto font-light leading-relaxed opacity-0 animate-fade-in-up" style="animation-delay:.3s">
            Bersiaplah! Saatnya masuk ke dunia M-GEN, arena para juara esports dan gaming masa kini.
          </p>
          <div class="mt-12 flex justify-center gap-6 opacity-0 animate-fade-in-up" style="animation-delay:.6s">
            <a href="{{ route('esport.tournaments.index', [], false) ?? '#' }}" class="group relative inline-flex items-center gap-2 px-8 py-4 glass-morphism hover:bg-white/20 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/25">
              <span class="relative z-10 text-white font-medium">Explore Tournaments</span>
              <i class="fas fa-arrow-right text-white transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
            <a href="{{ route('esport.news.index', [], false) ?? '#' }}" class="group inline-flex items-center gap-2 px-8 py-4 border border-white/30 rounded-xl hover:glass-morphism transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25">
              <span class="text-white font-medium">Latest News</span>
              <i class="fas fa-newspaper text-white transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- FEATURED GAMES --}}
  <section class="container mx-auto px-4 py-20" id="featured-games">
    <div class="text-center mb-16 opacity-0" id="games-header">
      <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in-up">Featured Games</h2>
      <p class="text-xl text-gray-400 animate-fade-in-up" style="animation-delay:.2s">Ikuti keseruan turnamen gaming kompetitif paling populer di M-GEN!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="games-grid">
      {{-- VALORANT --}}
      <div class="game-card group relative overflow-hidden rounded-2xl glass-morphism opacity-0" data-game="valorant">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-red-900/90 z-10"></div>
        <div class="w-full h-[400px] bg-gradient-to-br from-red-600 to-red-800 relative overflow-hidden">
          <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=60 height=60 viewBox=0 0 60 60 xmlns=http://www.w3.org/2000/svg%3E%3Cg fill=none fill-rule=evenodd%3E%3Cg fill=%23ffffff fill-opacity=0.1%3E%3Cpath d=%22m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
          <div class="absolute top-4 right-4 text-white text-6xl opacity-20">
            <i class="fas fa-crosshairs"></i>
          </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
          <div class="flex items-center mb-2">
            <i class="fas fa-fire text-red-400 mr-2"></i>
            <h3 class="text-2xl font-bold text-white">VALORANT</h3>
          </div>
          <p class="text-gray-300 mb-4">Strategic 5v5 character-based tactical shooter</p>
          <a href="{{ route('esport.tournaments.index', [], false) ?? '#' }}" class="inline-flex items-center gap-2 text-white hover:text-red-400 transition-colors group-hover:translate-x-2 transform duration-300">
            <span>View Tournaments</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        <div class="absolute inset-0 border-2 border-transparent group-hover:border-red-500/50 rounded-2xl transition-colors duration-300"></div>
      </div>

      {{-- PUBG --}}
      <div class="game-card group relative overflow-hidden rounded-2xl glass-morphism opacity-0" data-game="lol">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-blue-900/90 z-10"></div>
        <div class="w-full h-[400px] bg-gradient-to-br from-blue-600 to-blue-800 relative overflow-hidden">
          <div class="absolute top-4 right-4 text-white text-6xl opacity-20">
            <i class="fas fa-chess-king"></i>
          </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
          <div class="flex items-center mb-2">
            <i class="fas fa-crown text-blue-400 mr-2"></i>
            <h3 class="text-2xl font-bold text-white">PUBG</h3>
          </div>
          <p class="text-gray-300 mb-4">Battle royale mobile shooter game</p>
          <a href="{{ route('esport.tournaments.index', [], false) ?? '#' }}" class="inline-flex items-center gap-2 text-white hover:text-blue-400 transition-colors group-hover:translate-x-2 transform duration-300">
            <span>View Tournaments</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        <div class="absolute inset-0 border-2 border-transparent group-hover:border-blue-500/50 rounded-2xl transition-colors duration-300"></div>
      </div>

      {{-- MLBB --}}
      <div class="game-card group relative overflow-hidden rounded-2xl glass-morphism opacity-0" data-game="mlbb">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-purple-900/90 z-10"></div>
        <div class="w-full h-[400px] bg-gradient-to-br from-purple-600 to-purple-800 relative overflow-hidden">
          <div class="absolute top-4 right-4 text-white text-6xl opacity-20">
            <i class="fas fa-mobile-alt"></i>
          </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
          <div class="flex items-center mb-2">
            <i class="fas fa-gamepad text-purple-400 mr-2"></i>
            <h3 class="text-2xl font-bold text-white">Mobile Legends</h3>
          </div>
          <p class="text-gray-300 mb-4">Mobile MOBA with intense 5v5 battles</p>
          <a href="{{ route('esport.tournaments.index', [], false) ?? '#' }}" class="inline-flex items-center gap-2 text-white hover:text-purple-400 transition-colors group-hover:translate-x-2 transform duration-300">
            <span>View Tournaments</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        <div class="absolute inset-0 border-2 border-transparent group-hover:border-purple-500/50 rounded-2xl transition-colors duration-300"></div>
      </div>
    </div>
  </section>

  {{-- QUICK ACTIONS --}}
  <section class="container mx-auto px-4 py-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8" id="quick-actions">
      {{-- News --}}
      <div class="news-card glass-morphism p-6 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/20 group opacity-0">
        <div class="text-purple-400 mb-4">
          <i class="fas fa-newspaper text-5xl group-hover:animate-bounce"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-4 group-hover:text-purple-400 transition-colors">Latest News</h2>
        <p class="text-gray-300 mb-6">Jangan lewatkan berita terkini, hasil turnamen, dan pengumuman seru seputar dunia esports.</p>
        <a href="{{ route('esport.news.index', [], false) ?? '#' }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-lg transition-all duration-300 transform group-hover:translate-x-2 hover:shadow-lg hover:shadow-purple-500/50">
          <span>Read News</span>
          <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
        </a>
      </div>

      {{-- Community (placeholder) --}}
      <div class="news-card glass-morphism p-6 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl hover:shadow-red-500/20 group opacity-0">
        <div class="text-red-400 mb-4">
          <i class="fas fa-users text-5xl group-hover:animate-pulse"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-4 group-hover:text-red-400 transition-colors">Community</h2>
        <p class="text-gray-300 mb-6">Bergabunglah dengan komunitas gaming kami yang penuh semangat. Terhubung dengan sesama gamer, bagikan pengalaman, dan temukan teman baru</p>
        <a href="#" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-all duration-300 transform group-hover:translate-x-2 hover:shadow-lg hover:shadow-red-500/50">
          <span>Join Community</span>
          <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
        </a>
      </div>
    </div>
  </section>

  {{-- STATS --}}
  <section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-purple-900 via-blue-900 to-purple-900"></div>
    <div class="wave"></div>

    <div class="container relative mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8" id="stats-section">
        <div class="text-center opacity-0 animate-fade-in-up" data-delay="0">
          <div class="text-5xl font-bold text-white mb-2">
            <span class="counter" data-target="25">0</span>
            <i class="fas fa-trophy text-yellow-400 ml-2"></i>
          </div>
          <p class="text-gray-300 text-lg">Active Tournaments</p>
        </div>
        <div class="text-center opacity-0 animate-fade-in-up" data-delay="0.2">
          <div class="text-5xl font-bold text-white mb-2">
            <span class="counter" data-target="100">0</span>
            <i class="fas fa-user-friends text-blue-400 ml-2"></i>
          </div>
          <p class="text-gray-300 text-lg">Community Members</p>
        </div>
        <div class="text-center opacity-0 animate-fade-in-up" data-delay="0.4">
          <div class="text-5xl font-bold text-white mb-2">
            <span class="counter" data-target="50">0</span>
            <i class="fas fa-calendar-alt text-green-400 ml-2"></i>
          </div>
          <p class="text-gray-300 text-lg">Events</p>
        </div>
        <div class="text-center opacity-0 animate-fade-in-up" data-delay="0.6">
          <div class="text-5xl font-bold text-white mb-2">
            Rp.<span class="counter" data-target="5000000">0</span>
          </div>
          <p class="text-gray-300 text-lg">Prize Pool</p>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA --}}
  <section class="container mx-auto px-4 py-20">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900 via-blue-900 to-purple-900 animate-pulse-glow">
      <div class="absolute inset-0 bg-black/50"></div>
      <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-12" id="cta-section">
        <div class="text-center md:text-left mb-8 md:mb-0 opacity-0 animate-slide-in-left">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Join the Competition?</h2>
          <p class="text-xl text-gray-300">Register now and become part of our growing esports community!</p>
        </div>
        <div class="flex flex-wrap gap-4 opacity-0 animate-slide-in-right">
          <a href="{{ route('esport.tournaments.index', [], false) ?? '#' }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-purple-900 rounded-xl hover:bg-purple-100 transition-all duration-300 hover:scale-105 hover:shadow-lg group">
            <span class="font-bold">Join Tournament</span>
            <i class="fas fa-rocket transition-transform duration-300 group-hover:translate-x-1"></i>
          </a>
          <a href="{{ route('esport.home', [], false) ?? '#' }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white text-white rounded-xl hover:bg-white/10 transition-all duration-300 hover:scale-105 hover:shadow-lg group">
            <span class="font-bold">Learn More</span>
            <i class="fas fa-info-circle transition-transform duration-300 group-hover:translate-x-1"></i>
          </a>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('styles')
<style>
/* ===== Animations & Effects ===== */
@keyframes float-slow { 0%,100%{transform:translateY(0) rotate(0)} 33%{transform:translateY(-20px) rotate(2deg)} 66%{transform:translateY(10px) rotate(-1deg)} }
@keyframes float-medium { 0%,100%{transform:translateY(0) rotate(0)} 50%{transform:translateY(-15px) rotate(1deg)} }
@keyframes float-fast { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes gradient-text { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
@keyframes fadeInUp { from{opacity:0; transform:translateY(30px)} to{opacity:1; transform:translateY(0)} }
@keyframes slideInLeft { from{opacity:0; transform:translateX(-50px)} to{opacity:1; transform:translateX(0)} }
@keyframes slideInRight { from{opacity:0; transform:translateX(50px)} to{opacity:1; transform:translateX(0)} }
@keyframes pulse-glow { 0%,100%{box-shadow:0 0 20px rgba(168,85,247,.4)} 50%{box-shadow:0 0 40px rgba(168,85,247,.8), 0 0 60px rgba(168,85,247,.4)} }
@keyframes matrix-rain { 0%{transform:translateY(-100vh)} 100%{transform:translateY(100vh)} }
@keyframes neon-flicker { 0%,100%{text-shadow:0 0 10px #ff006e,0 0 20px #ff006e,0 0 30px #ff006e} 50%{text-shadow:0 0 5px #ff006e,0 0 10px #ff006e,0 0 15px #ff006e} }
@keyframes blink { 0%,50%{opacity:1} 51%,100%{opacity:0} }

.animate-float-slow{animation:float-slow 8s ease-in-out infinite}
.animate-float-medium{animation:float-medium 6s ease-in-out infinite}
.animate-float-fast{animation:float-fast 4s ease-in-out infinite}
.animate-gradient-text{background-size:200% auto; animation:gradient-text 3s linear infinite}
.animate-fade-in-up{animation:fadeInUp .8s ease-out forwards}
.animate-slide-in-left{animation:slideInLeft .8s ease-out forwards}
.animate-slide-in-right{animation:slideInRight .8s ease-out forwards}
.animate-pulse-glow{animation:pulse-glow 2s ease-in-out infinite}
.animate-neon-flicker{animation:neon-flicker 2s ease-in-out infinite}

.parallax-element{transition:transform .1s ease-out}

.matrix-char{color:#00ff00; font-family:'Courier New',monospace; position:absolute; animation:matrix-rain linear infinite; opacity:.7}

.glass-morphism{
  backdrop-filter: blur(16px) saturate(180%);
  background-color: rgba(17,25,40,.75);
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,.125);
}

.game-card{transition:all .4s cubic-bezier(.4,0,.2,1)}
.game-card:hover{transform:translateY(-10px) scale(1.02)}

.news-card{transition:all .3s ease; position:relative; overflow:hidden}
.news-card::before{
  content:'';
  position:absolute; top:0; left:-100%; width:100%; height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.1),transparent);
  transition:left .5s
}
.news-card:hover::before{left:100%}

.interactive-bg{position:relative; overflow:hidden}
.wave{
  position:absolute; bottom:0; left:0; width:100%; height:100px;
  background:url("data:image/svg+xml,%3Csvg viewBox='0 0 1200 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' opacity='.25' fill='%23667eea'/%3E%3Cpath d='M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z' opacity='.5' fill='%23667eea'/%3E%3Cpath d='M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z' fill='%23667eea'/%3E%3C/svg%3E") repeat-x;
}
@keyframes wave{0%,100%{transform:translateX(0)} 50%{transform:translateX(-25%)}}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
  .animate-float-slow, .animate-float-medium, .animate-float-fast,
  .animate-gradient-text, .animate-fade-in-up, .animate-slide-in-left,
  .animate-slide-in-right, .animate-pulse-glow, .animate-neon-flicker,
  .wave { animation: none !important; }
}
</style>
@endpush

@push('scripts')
<script>
// Utility: check reduced-motion
const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

class EsportsWebsite {
  constructor() {
    this.mouse = { x: window.innerWidth/2, y: window.innerHeight/2 };
    this.follower = null;
    this.intersectionObserver = null;
    this.init();
  }

  init() {
    this.setupTypingText();
    this.setupParallax();
    this.setupParticles();
    this.setupMatrixRain();
    this.setupMouseFollower();
    this.setupIntersectionObserver();
    this.setupCounters();
    this.setupGameCards();
    this.setupSmoothScrolling();
  }

  // 1) Typing effect
  setupTypingText() {
    const el = document.getElementById('typing-text');
    if (!el) return;
    const text = '';
    let i = 0;
    const type = () => {
      if (i <= text.length) {
        el.textContent = text.slice(0, i++);
        setTimeout(type, prefersReduced ? 0 : 100);
      }
    };
    type();
  }

  // 2) Parallax on mousemove
  setupParallax() {
    if (prefersReduced) return;
    const els = document.querySelectorAll('.parallax-element');
    if (!els.length) return;
    window.addEventListener('mousemove', (e) => {
      const { innerWidth:w, innerHeight:h } = window;
      const x = (e.clientX - w/2) / (w/2);
      const y = (e.clientY - h/2) / (h/2);
      els.forEach(el => {
        const speed = parseFloat(el.dataset.speed || '0.5');
        el.style.transform = `translate(${x*10*speed}px, ${y*10*speed}px)`;
      });
    });
  }

  // 3) Particles
  setupParticles() {
    const container = document.getElementById('particle-container');
    if (!container) return;
    const count = prefersReduced ? 0 : 60;
    for (let i = 0; i < count; i++) {
      const p = document.createElement('div');
      p.className = 'particle';
      p.style.position = 'absolute';
      p.style.width = '4px';
      p.style.height = '4px';
      p.style.borderRadius = '50%';
      p.style.background = 'rgba(168,85,247,.6)';
      p.style.left = Math.random() * 100 + '%';
      p.style.top = Math.random() * 100 + '%';
      p.style.opacity = 0.3 + Math.random() * 0.7;
      container.appendChild(p);

      // drift
      const drift = () => {
        if (prefersReduced) return;
        const dx = (Math.random() - .5) * 20;
        const dy = (Math.random() - .5) * 20;
        p.animate([{ transform: 'translate(0,0)' }, { transform: `translate(${dx}px,${dy}px)` }], {
          duration: 4000 + Math.random()*4000,
          direction: 'alternate',
          iterations: Infinity,
          easing: 'ease-in-out'
        });
      };
      drift();
    }
  }

  // 4) Matrix rain
  setupMatrixRain() {
    const bg = document.getElementById('matrix-bg');
    if (!bg) return;
    const cols = prefersReduced ? 0 : Math.floor(window.innerWidth / 40);
    const chars = 'アァカサタナハマヤャラワン0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (let i = 0; i < cols; i++) {
      const span = document.createElement('span');
      span.className = 'matrix-char';
      span.style.left = (i * 40) + 'px';
      span.style.animationDuration = (4 + Math.random() * 6) + 's';
      span.style.animationDelay = (Math.random() * 5) + 's';
      span.textContent = chars[Math.floor(Math.random()*chars.length)];
      bg.appendChild(span);

      // randomize content over time
      setInterval(() => {
        span.textContent = chars[Math.floor(Math.random()*chars.length)];
      }, 300 + Math.random()*1000);
    }
  }

  // 5) Mouse follower
  setupMouseFollower() {
    const follower = document.getElementById('mouse-follower');
    if (!follower) return;
    this.follower = follower;
    window.addEventListener('mousemove', (e) => {
      this.mouse.x = e.clientX;
      this.mouse.y = e.clientY;
    });
    const animate = () => {
      const rect = this.follower.getBoundingClientRect();
      const cx = rect.left + rect.width/2;
      const cy = rect.top + rect.height/2;
      const nx = cx + (this.mouse.x - cx) * 0.2;
      const ny = cy + (this.mouse.y - cy) * 0.2;
      this.follower.style.transform = `translate(${nx - 8}px, ${ny - 8}px)`;
      requestAnimationFrame(animate);
    };
    if (!prefersReduced) animate();
  }

  // 6) Reveal on view
  setupIntersectionObserver() {
    const els = document.querySelectorAll('#hero-content, #games-header, #games-grid .game-card, #quick-actions > * , #stats-section > *, #cta-section');
    if (!els.length) return;
    const opts = { threshold: 0.15 };
    this.intersectionObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.remove('opacity-0');
          entry.target.classList.add('animate-fade-in-up');
          this.intersectionObserver.unobserve(entry.target);
        }
      });
    }, opts);
    els.forEach(el => this.intersectionObserver.observe(el));
  }

  // 7) Counters
  setupCounters() {
    const counters = document.querySelectorAll('.counter');
    if (!counters.length) return;
    const easeOut = (t) => 1 - Math.pow(1 - t, 3);
    counters.forEach(el => {
      const target = parseInt(el.dataset.target || '0', 10);
      let start = null;
      const step = (ts) => {
        if (!start) start = ts;
        const p = Math.min(1, (ts - start) / (prefersReduced ? 0 : 1200));
        el.textContent = Math.floor(target * easeOut(p)).toLocaleString();
        if (p < 1) requestAnimationFrame(step);
      };
      const obs = new IntersectionObserver(([e]) => {
        if (e.isIntersecting) {
          requestAnimationFrame(step);
          obs.disconnect();
        }
      }, { threshold: .5 });
      obs.observe(el);
    });
  }

  // 8) Game card click sample
  setupGameCards() {
    document.querySelectorAll('.game-card').forEach(card => {
      card.addEventListener('click', () => {
        const url = "{{ route('esport.tournaments.index', [], false) ?? '#' }}";
        window.location.href = url;
      });
      card.style.cursor = 'pointer';
    });
  }

  // 9) Smooth scroll for internal anchors
  setupSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', (e) => {
        const id = a.getAttribute('href');
        const el = document.querySelector(id);
        if (el) {
          e.preventDefault();
          el.scrollIntoView({ behavior: prefersReduced ? 'auto' : 'smooth', block: 'start' });
        }
      });
    });
  }
}

document.addEventListener('DOMContentLoaded', () => new EsportsWebsite());
</script>
@endpush
