// const image = "//cdn.jsdelivr.net/npm/three-globe/example/img/earth-night.png";
const image = "/images/specials/earth.png";
const globediv = document.getElementById('globe');

console.log('globe container:', globediv);

let width = 40;// vw & vh
let height = 70;

let globewidht;
let globeheight;2
if (window.innerWidth < 1100) {
  width = 100;// vw & vh
  height = 70;
}

globewidht = window.innerWidth * width / 100;
globeheight = window.innerHeight * height / 100;
globediv.style.width = `${width}vw`;
globediv.style.height = `${height}vh`;

const markerSvg = `<svg viewBox="-4 0 36 36">
    <path fill="currentColor" d="M14,0 C21.732,0 28,5.641 28,12.6 C28,23.963 14,36 14,36 C14,36 0,24.064 0,12.6 C0,5.641 6.268,0 14,0 Z"></path>
    <circle fill="black" cx="14" cy="14" r="7"></circle>
  </svg>`;

const gData = [
  { name: "Home", label: "Amsterdam, NL", img:"me.png", project_id: "monkeyswing", lat: 52.3676, lng: 4.9041, size: 0.15, color: 'red' },

  { name: "Shanghai", label: "This is where Juice took place", img:"innerprojects/juice/group.png", project_id: "juice", lat: 31.2304, lng: 121.4737, size: 0.15, color: 'blue' },
  { name: "SanFranc",  label: "This is where Neighborhood took place", img:"", project_id: "neighborhood",  lat: 37.7749, lng: -122.4194, size: 0.05, color: 'blue' },

  { name: "Oslo", label: "Norway",img:"map/norway.png", lat: 59.9139, lng: 10.7522, size: 0.05, color: 'orange' },
  { name: "Majorca", label: "Spain", img:"map/mar.png", lat: 39.6953, lng: 3.0176, size: 0.05, color: 'orange' },
  { name: "Stockholm", label: "Sweden", img:"map/oslso.png", lat: 59.3293, lng: 18.0686, size: 0.05, color: 'orange' },
  { name: "Lyon", label: "France", img:"map/lyon.png", lat: 45.7640, lng: 4.8357, size: 0.05, color: 'orange' }
];

const startview = { lat: 27, lng: 24.9041, altitude: 2 };

const world = new Globe(globediv)
  .globeImageUrl(image)
  .backgroundColor("#fff")
  .showAtmosphere(false)
  .width(globewidht)
  .height(globeheight)
  .pointOfView(startview, 0)

  // data
  .pointsData(gData)
  .pointLat(d => (d.lat - 12))
  .pointLng(d => (d.lng - 2))
  .pointAltitude(d => d.size + 0.01)
  .pointRadius(() => 2)
  .pointColor(d => d.color)

  //tooltip
  .pointLabel(d =>
    `<div class="lead" style="margin: 0;">${d.name}</div>
     <div class="caption">${d.label}</div>
     <img src="images/${d.img}">`
  )

  .pointsMerge(false)
  .pointsTransitionDuration(0);

// pixelation
world.renderer().setPixelRatio(0.2);

world.onPointClick(d => {
  if (!d || !d.project_id) return;
  const target = document.getElementById(d.project_id);
  if (!target) return;
  scrolltotarget(target);
  console.info('clicked point:', d)
});

const controls = world.controls();
controls.autoRotate = true;
controls.autoRotateSpeed = 2;

window.myGlobeControls = controls;
window.myGlobe = world;

// load texture
const earthTexture = new THREE.TextureLoader().load('/images/specials/earth.png');
earthTexture.minFilter = THREE.NearestFilter;
earthTexture.magFilter = THREE.NearestFilter;
earthTexture.generateMipmaps = false;
const unlitMat = new THREE.MeshBasicMaterial({ map: earthTexture });

world.globeMaterial(unlitMat);


const hint = document.createElement('div');
hint.innerText = '⬢ Drag to explore';
hint.id = 'hintidpleaseremovethisdotcom';
Object.assign(hint.style, {
  position: 'absolute',
  top: '10px',
  left: '50%',
  transform: 'translateX(-50%)',
  padding: '6px 12px',
  background: 'rgba(0,0,0,0.6)',
  color: '#fff',
  borderRadius: '4px',
  fontFamily: 'sans-serif',
  fontSize: '1.9rem',
  pointerEvents: 'none',
  opacity: '1',
  transition: 'opacity 1s ease-out'
});
globediv.parentElement.appendChild(hint);


function scrolltotarget(target) {
  target.scrollIntoView({
    behavior: 'smooth',
    block: 'center',
    inline: 'nearest'
  });
  if (document.querySelector('.targetSelected')) document.querySelector('.targetSelected').classList.remove('targetSelected');
  target.classList.add('targetSelected');
}




const canvas = document.createElement('canvas');
const ctx = canvas.getContext('2d');
const img = new Image();
img.crossOrigin = '';
img.src = '/images/specials/earth.png';

img.onload = () => {
  canvas.width = img.width;
  canvas.height = img.height;
  ctx.drawImage(img, 0, 0);

  const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  const d = imgData.data;
  for (let i = 0; i < d.length; i += 4) {
    // since the image is already grayscale, r=g=b
    const v = d[i] < 128 ? 0 : 255;
    d[i] = v;
    d[i + 1] = v;
    d[i + 2] = v;
    // alpha (d[i+3]) stays at 255
  }
  ctx.putImageData(imgData, 0, 0);

  const bwTexture = new THREE.CanvasTexture(canvas);
  bwTexture.minFilter = THREE.NearestFilter;
  bwTexture.magFilter = THREE.NearestFilter;
  bwTexture.generateMipmaps = false;

  const bwMat = new THREE.MeshBasicMaterial({ map: bwTexture });
  world.globeMaterial(bwMat);
};