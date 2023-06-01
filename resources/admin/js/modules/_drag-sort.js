(function () {
  let groupElem = null;
  let draggableElem = null;
  let ghostElem = null;
  let breakpoints = [];
  let draggableShiftX = 0;
  let draggableShiftY = 0;

  const findDraggableElem = elem => {
    do {
      elem = elem.parentNode;

      if (elem === document || elem.hasAttribute('drag-sort-item')) {
        break;
      }
    } while (elem);

    return elem === document ? null : elem;
  };

  const findGroupElem = elem => {
    do {
      elem = elem.parentNode;

      if (elem === document || elem.hasAttribute('drag-sort-group')) {
        break;
      }
    } while (elem);

    return elem === document ? null : elem;
  };

  const createGhostElem = () => {
    let elem = document.createElement('div');

    if (draggableElem.tagName.toLowerCase() === 'tr') {
      let tr = document.createElement('tr');
      let td = document.createElement('td');
      td.setAttribute('colspan', '100%');
      td.appendChild(elem);
      tr.appendChild(td);
      return tr;
    } else {
      return elem;
    }
  };

  const collectBreakpoints = e => {
    breakpoints = [];

    groupElem.querySelectorAll('[drag-sort-item]').forEach(elem => {
      let bounding = elem.getBoundingClientRect();
      breakpoints.push(bounding.top + bounding.height / 2);
    });

    const bounding = draggableElem.getBoundingClientRect();

    draggableShiftX = e.pageX - bounding.x;
    draggableShiftY = e.pageY - bounding.y;

    draggableElem.style.width = `${bounding.width}px`;
    draggableElem.style.height = `${bounding.height}px`;
    draggableElem.style.position = 'fixed';

    ghostElem.style.height = `${bounding.height}px`;

    draggableElem.style.zIndex = 100;
    draggableElem.style.top = `${e.pageY - (draggableShiftY)}px`;
    draggableElem.style.left = `${e.pageX - (draggableShiftX)}px`;
  };

  document.addEventListener('mousedown', function (e) {
    if (e.which !== 1) {
      return;
    }
    let elem = e.target;
    do {
      if (elem === document || elem.hasAttribute('drag-sort-controll')) {
        break;
      }
      elem = elem.parentNode;
    } while (elem);

    if (elem === document || !elem.hasAttribute('drag-sort-controll')) {
      return;
    }

    draggableElem = findDraggableElem(elem);
    groupElem = findGroupElem(draggableElem);
    ghostElem = createGhostElem();

    draggableElem.before(ghostElem);

    collectBreakpoints(e);
  });

  document.addEventListener('mouseup', function (e) {
    if (draggableElem) {
      ghostElem.before(draggableElem);

      breakpoints = [];
      draggableElem.style = null;
      draggableElem = null;
      groupElem = null;
      ghostElem.remove();
      ghostElem = null;
    }
  });

  document.addEventListener('mousemove', function (e) {
    if (!draggableElem) {
      return;
    }

    draggableElem.style.top = `${e.pageY - (draggableShiftY)}px`;
    draggableElem.style.left = `${e.pageX - (draggableShiftX)}px`;

    let newIdx = null;
    for (let idx in breakpoints) {
      if (e.pageY <= breakpoints[idx]) {
        newIdx = idx;
        break;
      }
    }

    if (newIdx === null) {
      newIdx = groupElem.querySelectorAll('[drag-sort-item]').length;
      groupElem.querySelectorAll('[drag-sort-item]')[newIdx - 1].after(ghostElem);
    } else {
      groupElem.querySelectorAll('[drag-sort-item]')[newIdx].before(ghostElem);
    }
  });
}());
