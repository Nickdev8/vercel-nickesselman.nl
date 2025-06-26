<head>
  <title>Interactive Portfolio Tree</title>

  <style>
    html,
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
      background: #000;
    }

    #treeCanvas {
      display: block;
      background: #000;
      position: relative;
      z-index: 1;
    }

    /* tooltip styling */
    #tooltip {
      position: absolute;
      pointer-events: none;
      visibility: hidden;
      opacity: 0;
      padding: 6px 12px;
      background: rgba(255, 255, 255, 0.9);
      color: #222;
      font-family: sans-serif;
      font-size: 13px;
      border-radius: 4px;
      white-space: nowrap;
      transition: opacity 0.2s ease, visibility 0.2s;
      z-index: 9999;
    }

    #tooltip.visible {
      visibility: visible;
      opacity: 1;
    }

    #tooltip::after {
      content: '';
      position: absolute;
      bottom: 100%;
      left: 50%;
      transform: translateX(-50%);
      border-width: 6px;
      border-style: solid;
      border-color: rgba(255, 255, 255, 0.9) transparent transparent transparent;
    }
  </style>
</head>


<canvas id="treeCanvas" style="max-height:86vh; width:100vw"></canvas>
<div id="tooltip"></div>
<script>

  const canvas = document.getElementById('treeCanvas');
  const ctx = canvas.getContext('2d');
  const tooltip = document.getElementById('tooltip');

  const CURVE = 0.2;
  const DECAY = 0.75;
  const MIN_SCALE = 0.18;
  let width, height, BASE_LEN;
  let offsetX = 0, offsetY = 400;
  let isDragging = false, startX, startY;

  const treeData = {
    name: 'Root', project: null, children: [
      { name: 'Proj A', project: 'https://example.com/a', children: [] },
      {
        name: 'Cat B', project: null, children: [
          { name: 'B1', project: 'https://example.com/b1', children: [] },
          {
            name: 'B2', project: 'https://example.com/b2', children: [
              { name: 'C', project: 'https://example.com/c', children: [] }
            ]
          }
        ]
      },
      { name: 'Proj C', project: 'https://example.com/c', children: [] }
    ]
  };

  function drawNode(node, x, y, angle, depth = 0) {
    const len = BASE_LEN * Math.pow(DECAY, depth);
    const x2 = x + Math.cos(angle) * len;
    const y2 = y + Math.sin(angle) * len;

    const cx = x + Math.cos(angle) * len * 0.5 + Math.sin(angle) * len * 0.3 * CURVE;
    const cy = y + Math.sin(angle) * len * 0.5 - Math.cos(angle) * len * 0.3 * CURVE;

    ctx.lineCap = 'round';
    ctx.shadowColor = 'rgba(0,0,0,0.7)';
    ctx.shadowBlur = 6;
    ctx.strokeStyle = depth === 0 ? '#D2B48C' : '#66FF66';
    ctx.lineWidth = Math.max(3, 12 - depth * 1.7);

    ctx.beginPath();
    ctx.moveTo(x, y);
    ctx.quadraticCurveTo(cx, cy, x2, y2);
    ctx.stroke();

    const spread = Math.PI / (depth + 2);
    node.children.forEach((c, i) => {
      const a = angle - spread / 2 + (i / (node.children.length - 1 || 1)) * spread;
      drawNode(c, x2, y2, a, depth + 1);
    });

    ctx.shadowBlur = 0;
    ctx.fillStyle = node.project ? '#00E676' : '#00CCCC';
    ctx.beginPath();
    ctx.arc(x2, y2, 6 + (node.children.length === 0 ? 2 : 0), 0, 2 * Math.PI);
    ctx.fill();

    if (node.children.length === 0) {
      ctx.fillStyle = '#27AE60';
      ctx.beginPath();
      ctx.moveTo(x2, y2);
      ctx.lineTo(x2 + Math.cos(angle - 0.3) * 12, y2 + Math.sin(angle - 0.3) * 12);
      ctx.lineTo(x2 + Math.cos(angle + 0.3) * 12, y2 + Math.sin(angle + 0.3) * 12);
      ctx.closePath();
      ctx.fill();
    }

    ctx.font = `${14 - depth}px sans-serif`;
    ctx.fillStyle = '#FFF';
    ctx.textAlign = depth === 0 ? 'center' : (Math.cos(angle) > 0 ? 'left' : 'right');
    ctx.fillText(node.name, x2 + Math.cos(angle) * 16, y2 + Math.sin(angle) * 16);

    node._pos = { x: x2, y: y2 };
    node._radius = 20;
  }

  function draw() {
    ctx.clearRect(0, 0, width, height);
    ctx.save();
    ctx.translate(offsetX, offsetY);
    drawNode(treeData, width / 2, height / 2, -Math.PI / 2);
    ctx.restore();
  }

  function hitTest(node, p) {
    const dx = p.x - node._pos.x, dy = p.y - node._pos.y;
    if (dx * dx + dy * dy <= node._radius * node._radius) return node;
    for (let c of node.children) {
      const h = hitTest(c, p);
      if (h) return h;
    }
    return null;
  }

  function resize() {
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
    BASE_LEN = Math.min(width, height) * MIN_SCALE;
    draw();
  }
  window.addEventListener('resize', resize);
  resize();

  canvas.addEventListener('mousedown', e => {
    isDragging = true;
    startX = e.clientX - offsetX;
    startY = e.clientY - offsetY;
  });
  canvas.addEventListener('mousemove', e => {
    if (isDragging) {
      offsetX = e.clientX - startX;
      offsetY = e.clientY - startY;
      draw();
      tooltip.classList.remove('visible');
    } else {
      const pos = { x: e.clientX - offsetX, y: e.clientY - offsetY };
      const hit = hitTest(treeData, pos);
      if (hit) {
        tooltip.textContent = hit.name;
        const { width: tw, height: th } = tooltip.getBoundingClientRect();
        let left = e.clientX + 12, top = e.clientY + 12;
        if (left + tw > window.innerWidth) left = e.clientX - tw - 12;
        if (top + th > window.innerHeight) top = e.clientY - th - 12;
        tooltip.style.left = left + 'px';
        tooltip.style.top = top + 'px';
        tooltip.classList.add('visible');
      } else {
        tooltip.classList.remove('visible');
      }
    }
  });
  canvas.addEventListener('mouseup', () => isDragging = false);
  canvas.addEventListener('mouseleave', () => isDragging = false);

  canvas.addEventListener('click', e => {
    const pos = { x: e.clientX - offsetX, y: e.clientY - offsetY };
    const hit = hitTest(treeData, pos);
    if (hit && hit.project) window.open(hit.project, '_blank');
  });
</script>