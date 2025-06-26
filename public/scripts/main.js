//old, for random smilies
const emoticons = [
  ":)",   // smile
  ":-)",  // smile (nose)
  ":D",   // big grin
  ":-D",  // big grin (nose)
  ":(",   // frown
  ":-(",  // frown (nose)
  ";)",   // wink
  ";-)",  // wink (nose)
  ":P",   // tongue out
  ":-P",  // tongue out (nose)
  ":O",   // surprised
  ":-O",  // surprised (nose)
  ":/",   // skeptical
  ":-/",  // skeptical (nose)
  ":|",   // neutral
  ":-|",  // neutral (nose)
  ":S",   // uneasy
  ":-S",  // uneasy (nose)
  ":*",   // kiss
  ":-*",  // kiss (nose)
  "<3",   // heart
  ":'(",  // crying
  ":’-(", // crying (alternate apostrophe)
  "B)",   // cool (sunglasses)
  "B-)"   // cool (sunglasses, nose)
];

document.addEventListener('DOMContentLoaded', () => {
  const randomemiji = document.getElementById('randomemiji');
  if (randomemiji)
    randomemiji.innerHTML = emoticons[Math.floor(Math.random() * emoticons.length)];

  const imgs = document.querySelectorAll('.iconholingholder img');

  imgs.forEach(img => {
    img.classList.add('physics', 'physics-nested')
  });
});