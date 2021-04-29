
function onWindowResize(event) {
        let dropdownList = document.getElementById('dropdownUserItems');
        let dropdownLinks = dropdownList.querySelectorAll('a, button');

        if (window.innerWidth < 768) {
                dropdownList.classList.remove('dropdown-menu', 'dropdown-menu-end');
                
                for (let link of dropdownLinks) {
                        link.classList.remove('dropdown-item');
                        link.classList.add('btn', 'btn-outline-light');
                }
        }
        else {
                dropdownList.classList.add('dropdown-menu', 'dropdown-menu-end');

                for (let link of dropdownLinks) {
                        link.classList.add('dropdown-item');
                        link.classList.remove('btn', 'btn-outline-light');
                }
        }
}

onWindowResize();
window.addEventListener('resize', onWindowResize);

function updateMaxAttendanceInput() {
    let maxAttendance = document.querySelector('input#maxAttendance');
    if (maxAttendance != null) maxAttendance.hidden = !switchLimitedAttendance.checked;
}

let switchLimitedAttendance = document.querySelector('input#switchLimitedAttendance')
if (switchLimitedAttendance != null) {
    switchLimitedAttendance.addEventListener('change', updateMaxAttendanceInput);
    updateMaxAttendanceInput();
}
