
function onWindowResize(event) {
    let dropdownList = document.getElementById('dropdownUserItems');

    if (dropdownList != null) {
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

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler, handlerData = {}, acceptHeader = 'text/html') {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('Accept', acceptHeader);
    request.addEventListener('load', function() {
        handler.call(this, handlerData);
    });
    request.send(encodeForAjax(data));
}

let createPollForm = document.getElementById('createPollForm');
let createPollOptions = document.getElementById('createPollOptions');
let createPollError = document.getElementById('createPollError');
let pollsSection = document.querySelector('section#polls');

if (createPollOptions != null) {
    let addPollOptionButton = document.getElementById('addPollOption');
    addPollOptionButton.addEventListener('click', addPollOption);

    createPollForm.addEventListener('submit', sendCreatePollRequest);
}

function sendCreatePollRequest(event) {
    let question = document.getElementById('createPollQuestion').value;
    let csrfToken = createPollForm.querySelector('input[name=_token]').value;

    let optionInputs = createPollOptions.querySelectorAll('input');
    let options = [];

    for (let input of optionInputs) {
        if (input.value.indexOf('|') > -1) {
            createPollError.innerHTML = 'The | character cannot be used inside poll options.';
            event.preventDefault();
            return;
        }

        options.push(input.value);
    }

    let data = {
        _token: csrfToken,
        question: question,
        options: options.join('|')
    };

    sendAjaxRequest(createPollForm.method, createPollForm.action, data, createPollHandler);
    event.preventDefault();
}

function createPollHandler() {
    if (this.status !== 200) {
        createPollError.innerHTML = this.responseText;
        return;
    }

    document.getElementById('createPollQuestion').value = "";
    let optionInputs = createPollOptions.querySelectorAll('input');

    for (let input of optionInputs) {
        input.value = "";

        if (input.parentElement.querySelector('button') != null) {
            input.parentElement.remove();
        }
    }

    document.getElementById('newPollOption').value = "";

    pollsSection.innerHTML += this.responseText;
    
    let closeModalButton = document.getElementById('createPollModalClose');
    closeModalButton.click();
}

function deletePollOption() {
    this.parentElement.remove();
}

function addPollOption() {
    let newPollOptionInput = document.getElementById('newPollOption');
    let text = newPollOptionInput.value.trim();

    if (text && text.length > 0) {
        let li = document.createElement('li');
        li.classList.add('input-group');

        let input = document.createElement('input');
        input.type = 'text';
        input.classList.add('form-control');
        input.required = true;
        input.value = text;

        li.appendChild(input);

        let button = document.createElement('button');
        button.classList.add('btn', 'btn-danger');
        button.ariaLabel = 'Remove option';
        
        let icon = document.createElement('i');
        icon.classList.add('fa', 'fa-remove');

        button.appendChild(icon);
        button.addEventListener('click', deletePollOption);

        li.appendChild(button);
        
        newPollOptionInput.value = "";
        createPollOptions.appendChild(li);
    }
}

// ----- Comments API -----

// ----- Button Event Listeners -----
function onReplyButtonClicked() {
    let article = this.closest('article');
    let replyForm = article.querySelector('form.form-comment-post');
    replyForm.hidden = false;
}

function onDeleteButtonClicked(event) {
    event.preventDefault();
    
    let article = this.closest('article');
    if (article != null) {
        sendAjaxRequest(this.querySelector('input[name=_method]').value, this.action, {}, deleteCommentHandler, { id: article.getAttribute('data-id') });
    }
}

function deleteCommentHandler(data) {
    if (this.status !== 200) {
        document.getElementById('commentsError').innerHTML = this.responseText;
        return;
    }

    let comment = document.querySelector('article[data-id=\"' + data.id + '\"] > .comment');

    if (comment != null) {
        comment.outerHTML = this.responseText;
    }
}

document.querySelectorAll('button.button-comment-reply').forEach(function(button) { button.addEventListener('click', onReplyButtonClicked) });
document.querySelectorAll('button.button-comment-delete').forEach(function(button) { button.parentElement.addEventListener('submit', onDeleteButtonClicked) });

function sendPostCommentRequest(form) {
    let csrfToken = form.querySelector('input[name=_token]').value;
    let text = form.querySelector('textarea[name=text]').value;

    let idParent;
    let idParentElement = form.querySelector('input[name=idParent]');
    if (idParentElement != null) idParent = idParentElement.value;

    let data = {
        _token: csrfToken,
        text: text,
    };

    if (idParent != null) data['idParent'] = idParent;
    sendAjaxRequest(form.method, form.action, data, postCommentHandler, { idParent: idParent });
}

function editCommentHandler(data) {
    // TODO
}

function postCommentHandler(data) {
    if (this.status !== 200) {
        document.getElementById('commentsError').innerHTML = this.responseText;
        return;
    }

    let newForm, replyButton, deleteButton;

    if (data.idParent == null) {
        // New root comment
        let commentsDiv = document.querySelector('section#comments > div');
        commentsDiv.innerHTML = this.responseText + commentsDiv.innerHTML;

        // Clear the comment form
        rootCommentForm.querySelector('textarea[name=text]').value = "";

        newForm = commentsDiv.querySelector('form.form-comment-post');
        replyButton = commentsDiv.querySelector('button.button-comment-reply');
        deleteButton = commentsDiv.querySelector('button.button-comment-delete');
    }
    else {
        // New child comment
        let parentComment = document.querySelector('section#comments article[data-id=\"' + data.idParent + '\"]');

        if (parentComment != null) {
            let parentCommentChildren = parentComment.querySelector('section');
            let replyForm = parentComment.querySelector('form.form-comment-post');

            replyForm.hidden = true;
            replyForm.querySelector('textarea[name=text]').value = "";
            parentCommentChildren.innerHTML = this.responseText + parentCommentChildren.innerHTML;

            newForm = parentCommentChildren.querySelector('form.form-comment-post');
            replyButton = parentCommentChildren.querySelector('button.button-comment-reply');
            deleteButton = parentCommentChildren.querySelector('button.button-comment-delete');
        }
    }
    
    newForm.addEventListener('submit', function(event) {
        event.preventDefault();
        sendPostCommentRequest(newForm);
    });
    
    replyButton.addEventListener('click', onReplyButtonClicked);
    deleteButton.parentElement.addEventListener('submit', onDeleteButtonClicked);

    let commentCountSpan = document.querySelector('span#commentCount');
    commentCountSpan.innerHTML = parseInt(commentCountSpan.innerHTML) + 1;
}

let rootCommentForm = document.querySelector('#commentsTab > div > form.form-comment-post');
let postCommentForms = document.querySelectorAll('form.form-comment-post');

for (let form of postCommentForms) {
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        sendPostCommentRequest(form);
    });
}
