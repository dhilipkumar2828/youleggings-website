// Product Image Assets
const aboutImage = './images/Aqua Flex Active/_DSC9004-Edit.jpg';
const brandLogo = './images/logo-new.png';
const solidImage = './images/Cobalt Core Legging/_DSC8962.jpg';
const patternedImage = './images/Products/_DSC8893-Edit.jpg';
const activewearImage = './images/Products/_DSC8789-Edit.jpg';
const essentialsImage = './images/Products/_DSC8716-Edit.jpg';
const newArrivalOne = './images/Products/_DSC8832.jpg';
const newArrivalTwo = './images/Products/_DSC8752-Edit.jpg';
const newArrivalThree = './images/Products/_DSC8597-Edit.jpg';
const newArrivalFour = './images/Products/_DSC8489-Edit.jpg';

// Slide Data
const slides = [
  {
    id: 1,
    script1: "Go Beyond",
    script2: "Basic",
    bold: "TOUR OF YOUR",
    huge: "Collection",
    bgColor: "#e1f5f1",
    textColor: "#1e40af",
    accentColor: "#ffb300",
    titleColor: "#ffd54f",
    images: [newArrivalOne, newArrivalTwo, newArrivalThree, newArrivalFour]
  },
  {
    id: 2,
    script1: "Elegance in",
    script2: "Every Stitch",
    bold: "LUXURY MADE",
    huge: "Affordable",
    bgColor: "#fce4ec",
    textColor: "#880e4f",
    accentColor: "#ec407a",
    titleColor: "#f06292",
    images: [solidImage, patternedImage, activewearImage, essentialsImage]
  },
  {
    id: 3,
    script1: "Pure Comfort",
    script2: "Deep Movement",
    bold: "CRAFTED FOR",
    huge: "Confidence",
    bgColor: "#f1f8e9",
    textColor: "#33691e",
    accentColor: "#689f38",
    titleColor: "#8bc34a",
    images: [activewearImage, newArrivalOne, essentialsImage, solidImage]
  }
];

let currentSlide = 0;
let slideInterval;

function updateHero() {
  const slide = slides[currentSlide];
  const heroSection = document.getElementById('hero-section');
  const heroContent = document.getElementById('hero-content');
  const heroImagesContainer = document.getElementById('hero-images-container');
  const indicators = document.querySelectorAll('.slide-indicator');

  // Update Background Color
  heroSection.style.backgroundColor = slide.bgColor;

  // Update Hero Content (Typography)
  heroContent.innerHTML = `
    <h2 class="font-script text-[40px] md:text-[80px] leading-none mb-0 -rotate-3 translate-x-4 md:translate-x-8 animate-in fade-in slide-in-from-right-10" style="color: ${slide.textColor}">
      ${slide.script1}
    </h2>
    <h2 class="font-script text-[30px] md:text-[60px] leading-none mb-4 -rotate-3 translate-x-12 md:translate-x-16 animate-in fade-in slide-in-from-right-10" style="color: ${slide.textColor}; animation-delay: 50ms;">
      ${slide.script2}
    </h2>
    
    <div class="flex flex-col items-center lg:items-end translate-y-[-20px] animate-in fade-in slide-in-from-right-10" style="animation-delay: 100ms;">
      <p class="font-sans font-black text-[28px] md:text-[52px] leading-none tracking-tight" style="color: ${slide.accentColor}">
        ${slide.bold}
      </p>
      <h1 class="font-display text-[70px] md:text-[140px] leading-[0.8] tracking-widest uppercase" style="color: ${slide.titleColor}">
        ${slide.huge}
      </h1>
    </div>

    <div class="mt-8 flex gap-4 animate-in fade-in slide-in-from-right-10" style="animation-delay: 200ms;">
      <a href="#shop" class="px-8 py-3 bg-gray-900 text-white font-black uppercase tracking-widest text-[10px] hover:bg-[#ec407a] transition-all">
        Shop Now
      </a>
    </div>
  `;

  // Update Hero Images
  heroImagesContainer.innerHTML = slide.images.map((img, idx) => {
    const mobileHeight = 320 + (idx === 1 ? 60 : idx === 2 ? 30 : idx === 3 ? 0 : 30);
    const desktopHeight = 520 + (idx === 1 ? 60 : idx === 2 ? 30 : idx === 3 ? 0 : 30);

    return `
      <div 
        class="w-1/4 transition-all duration-700 ease-out h-[${mobileHeight}px] md:h-[${desktopHeight}px] hover:scale-[1.05] z-${(idx + 1) * 10} animate-in fade-in slide-in-from-bottom-10"
        style="height: ${window.innerWidth < 768 ? mobileHeight : desktopHeight}px; animation-delay: ${idx * 100}ms"
      >
        <img src="${img}" alt="Model ${idx + 1}" class="w-full h-full object-cover object-top shadow-lg" />
      </div>
    `;
  }).join('');

  // Update Indicators
  indicators.forEach((indicator, idx) => {
    const line = indicator.querySelector('.indicator-line');
    if (idx === currentSlide) {
      line.classList.remove('w-8', 'md:w-16', 'bg-gray-900/20');
      line.classList.add('w-16', 'md:w-24', 'bg-gray-900');
    } else {
      line.classList.remove('w-16', 'md:w-24', 'bg-gray-900');
      line.classList.add('w-8', 'md:w-16', 'bg-gray-900/20');
    }
  });
}

function goToSlide(index) {
  currentSlide = index;
  updateHero();
  resetTimer();
}

function resetTimer() {
  clearInterval(slideInterval);
  slideInterval = setInterval(() => {
    currentSlide = (currentSlide + 1) % slides.length;
    updateHero();
  }, 6000);
}

// Initial Call
document.addEventListener('DOMContentLoaded', () => {
  updateHero();
  resetTimer();

  // Initialize Lucide Icons
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
});

// Handle window resize for image heights
window.addEventListener('resize', () => {
  updateHero();
});
