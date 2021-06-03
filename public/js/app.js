
let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});

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

    if (method.toUpperCase() === 'GET') {
        url += '?' + encodeForAjax(data);
    }

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('Accept', acceptHeader);
    request.addEventListener('load', function() {
        handler.call(this, handlerData);
    });

    if (method.toUpperCase() === 'GET') {
        request.send();
    }
    else {
        request.send(encodeForAjax(data));
    }
}

// ----- Polls API -----

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

function sendPutPollAnswerRequest() {
    let form = this.closest('form');

    let csrfToken = form.querySelector('input[name=_token]').value;
    let method = form.querySelector('input[name=_method]').value;

    let option = this.value;

    let data = {
        _token: csrfToken,
        option: option,
    };

    sendAjaxRequest(method, form.action, data, pollAnswerHandler, { id: this.closest('article').getAttribute('data-id') });
}

function pollAnswerHandler(data) {
    if (this.status !== 200) {
        document.getElementById('pollError').innerHTML = this.responseText;
        return;
    }

    let query = '#polls article[data-id=\"' + data.id + '\"';

    let article = document.querySelector(query);
    article.outerHTML = this.responseText;
    article = document.querySelector(query); // We need to run querySelector again since the article HTML has changed

    // Add event listeners
    let inputs = article.querySelectorAll('.input-poll-answer');
    for (let input of inputs) {
        input.addEventListener('change', sendPutPollAnswerRequest);
    }

    let deleteForm = article.querySelector('.form-remove-poll-answer');
    if (deleteForm != null) deleteForm.addEventListener('submit', sendDeletePollAnswerRequest);
}

function sendDeletePollAnswerRequest(event) {
    event.preventDefault();

    let csrfToken = this.querySelector('input[name=_token]').value;
    let method = this.querySelector('input[name=_method]').value;

    sendAjaxRequest(method, this.action, { _token: csrfToken }, pollAnswerHandler, {id: this.closest('article').getAttribute('data-id') });
}

let pollAnswerInputs = document.querySelectorAll('.input-poll-answer');
for (let input of pollAnswerInputs) {
    input.addEventListener('change', sendPutPollAnswerRequest);
}

let removePollAnswerForms = document.querySelectorAll('.form-remove-poll-answer');
for (let form of removePollAnswerForms) {
    form.addEventListener('submit', sendDeletePollAnswerRequest);
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
            parentCommentChildren.insertAdjacentHTML('afterbegin', this.responseText);

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

// ----- Invitations API -----


let sendInvitationForm = document.querySelector('form#sendInvitationForm');

if (sendInvitationForm != null) {
    sendInvitationForm.addEventListener('submit', sendCreateInvitationRequest);
}

function clearInvitationsPageErrors() {
    let invitationsError = document.getElementById('invitationsError');
    if (invitationsError !== null) {
        invitationsError.innerHTML = "";
    }

    let cancelInvitationsError = document.getElementById('cancelInvitationsError');
    if (cancelInvitationsError !== null) {
        cancelInvitationsError.innerHTML = "";
    }
    
    let updateJoinRequestError = document.getElementById('updateJoinRequestError');
    if (updateJoinRequestError !== null) {
        updateJoinRequestError.innerHTML = "";
    }
}

function sendCreateInvitationRequest(event) {
    event.preventDefault();
    let csrfToken = this.querySelector('input[name=_token]').value;
    let invite = this.querySelector('input[name=invite]').value;

    let data = {
        _token: csrfToken,
        invite: invite,
    };

    sendAjaxRequest(this.method, this.action, data, createInvitationHandler);
}

function createInvitationHandler() {
    clearInvitationsPageErrors();
    if (this.status !== 200) {
        document.getElementById('invitationsError').innerHTML = this.responseText;
        return;
    }

    let invite = sendInvitationForm.querySelector('input[name=invite]');
    invite.value = '';
    
    let invitations = document.getElementById('invitations');
    invitations.insertAdjacentHTML('afterbegin', this.responseText);

    let deleteForm = invitations.querySelector('.form-delete-invitation');
    deleteForm.addEventListener('submit', sendDeleteInvitationRequest);
}

let deleteInvitationForms = document.querySelectorAll('.form-delete-invitation');
for (let form of deleteInvitationForms) {
    form.addEventListener('submit', sendDeleteInvitationRequest);
}

function sendDeleteInvitationRequest(event) {
    event.preventDefault();
    let csrfToken = this.querySelector('input[name=_token]').value;
    let method = this.querySelector('input[name=_method]').value;

    let data = {
        _token: csrfToken,
    };

    let invitationCard = this.closest('div.card');
    sendAjaxRequest(method, this.action, data, deleteInvitationHandler, { invitationCard: invitationCard });
}

function deleteInvitationHandler(data) {
    clearInvitationsPageErrors();
    if (this.status !== 200) {
        document.getElementById('cancelInvitationsError').innerHTML = this.responseText;
        return;
    }

    data.invitationCard.remove();
}

let deleteAllForm = document.querySelector('.form-delete-all-invitations');
if (deleteAllForm !== null) {
    deleteAllForm.addEventListener('submit', sendDeleteAllInvitationsRequest);
}

function sendDeleteAllInvitationsRequest(event) {
    event.preventDefault();
    let csrfToken = this.querySelector('input[name=_token]').value;
    let method = this.querySelector('input[name=_method]').value;

    let data = {
        _token: csrfToken,
    };

    sendAjaxRequest(method, this.action, data, deleteAllInvitationsHandler);
}

function deleteAllInvitationsHandler() {
    clearInvitationsPageErrors();
    if (this.status !== 200) {
        document.getElementById('cancelInvitationsError').innerHTML = this.responseText;
        return;
    }

    document.getElementById('invitations').innerHTML = "";
}

let manageInvitationForms = document.querySelectorAll('.form-manage-invitation');
for (let form of manageInvitationForms) {
    form.addEventListener('submit', sendUpdateInvitationRequest);
}

function sendUpdateInvitationRequest(event) {
    event.preventDefault();

    let csrfToken = this.querySelector('input[name=_token]').value;
    let method = this.querySelector('input[name=_method]').value;
    let status = this.querySelector('input[name=status]').value;

    let invitation = this.parentNode;
    while (invitation.className !== 'card card-invitation') {
        invitation = invitation.parentNode;
    }

    let data = {
        _token: csrfToken,
        status: status,
    };

    sendAjaxRequest(method, this.action, data, updateInvitationHandler, { invitation: invitation });
}

function updateInvitationHandler(data) {
    if (this.status !== 200) {
        document.getElementById('updateInvitationError').innerHTML = this.responseText;
        return;
    }

    document.getElementById('updateInvitationError').innerHTML = "";
    data.invitation.remove();
}

// ----- Join Requests API -----

let joinRequestButton = document.getElementById('joinRequestButton');
if (joinRequestButton != null) {
    joinRequestButton.addEventListener('click', sendCreateJoinRequestRequest);
}

function sendCreateJoinRequestRequest(event) {
    event.preventDefault();
    sendAjaxRequest('POST', this.href, {}, createJoinRequestHandler);
}

function createJoinRequestHandler() {
    if (this.status !== 200) {
        document.getElementById('joinRequestError').innerHTML = this.responseText;
        return;
    }
    
    document.getElementById('joinRequestError').innerHTML = "";
    let requestToJoinDiv = document.getElementById('requestToJoin');
    requestToJoinDiv.innerHTML = this.responseText;
}

let manageJoinRequestForms = document.querySelectorAll('.form-manage-join-request');
for (let form of manageJoinRequestForms) {
    form.addEventListener('submit', sendUpdateJoinRequestRequest);
}

function sendUpdateJoinRequestRequest(event) {
    event.preventDefault();
    let csrfToken = this.querySelector('input[name=_token]').value;
    let method = this.querySelector('input[name=_method]').value;
    let status = this.querySelector('input[name=status]').value;
    
    let joinRequest = this.parentNode;
    while (joinRequest.className !== 'card') {
        joinRequest = joinRequest.parentNode;
    }

    let data = {
        _token: csrfToken,
        status: status,
    };

    sendAjaxRequest(method, this.action, data, updateJoinRequestHandler, { joinRequest: joinRequest });
}

function updateJoinRequestHandler(data) {
    clearInvitationsPageErrors();
    if (this.status !== 200) {
        document.getElementById('updateJoinRequestError').innerHTML = this.responseText;
        return;
    }

    data.joinRequest.remove();
}


let manageAllJoinRequestForms = document.querySelectorAll('.form-manage-all-join-request');
for (let form of manageAllJoinRequestForms) {
    form.addEventListener('submit', sendUpdateAllJoinRequestRequest);
}

function sendUpdateAllJoinRequestRequest(event) {
    event.preventDefault();

    let csrfToken = this.querySelector('input[name=_token]').value;
    let method = this.querySelector('input[name=_method]').value;
    let status = this.querySelector('input[name=status]').value;

    let data = {
        _token: csrfToken,
        status: status,
    };

    sendAjaxRequest(method, this.action, data, updateAllJoinRequestHandler);
}

function updateAllJoinRequestHandler() {
    clearInvitationsPageErrors();
    if (this.status !== 200) {
        document.getElementById('updateJoinRequestError').innerHTML = this.responseText;
        return;
    }

    // If the event doesn't have enough space for everyone, the status should be different from 200
    document.getElementById('join-requests').innerHTML = "";
}

// ----- Event Cancellation -----
let eventCancellationButton = document.getElementById('eventCancellation');
if (eventCancellationButton != null) {
    eventCancellationButton.addEventListener('click', sendEventCancellationRequest);
}

function sendEventCancellationRequest(event) {
    event.preventDefault();
    sendAjaxRequest('POST', this.href, {}, eventCancellationHandler);
}

function eventCancellationHandler() {
    if (this.status !== 200) {
        document.getElementById('eventCancellationError').innerHTML = this.responseText;
        return;
    }
    window.location.href = this.responseText;
}

// ----- Search API -----

// Ajax will be used for the search events form only when in the search results page
let searchEventsForm = document.getElementById('searchEventsForm');
if (searchEventsForm !== null) {
    searchEventsForm.addEventListener('submit', sendSearchEventsRequest);
}

let searchFiltersSection = document.getElementById('searchFilters');
let searchEventsSpinner = document.getElementById('searchResultsSpinner');
let searchEventsError = document.getElementById('searchEventsError');

for (let input of document.querySelectorAll('#searchFilters input, #searchFilters select')) {
    input.addEventListener('change', sendSearchEventsRequest);
}

function sendSearchEventsRequest(event) {
    if (event.type === 'submit') {
        event.preventDefault();
    }

    let query = searchEventsForm.querySelector('input[name=query]').value;
    let startDate = searchFiltersSection.querySelector('input[name=startDate]').value;
    let endDate = searchFiltersSection.querySelector('input[name=endDate]').value;
    let category = searchFiltersSection.querySelector('select[name=category]').value;

    let data = {
        query: query,
    };

    if (startDate !== null && startDate !== '') data.startDate = startDate;
    if (endDate !== null && endDate !== '') data.endDate = endDate;
    if (category !== null && category !== '') data.category = category;

    let checkboxes = searchFiltersSection.querySelectorAll('#typeCheckboxes input');
    let types = [];

    for (let checkbox of searchFiltersSection.querySelectorAll('#typeCheckboxes input')) {
        if (checkbox.checked) {
            types.push(checkbox.value);
        }
    }

    if (types.length !== 0 && types.length !== checkboxes.length) {
        data.types = types;
    }

    searchEventsSpinner.ariaHidden = false;
    searchEventsSpinner.removeAttribute('hidden');
    sendAjaxRequest(searchEventsForm.method, searchEventsForm.action, data, searchEventsHandler);
}

function searchEventsHandler() {
    searchEventsSpinner.ariaHidden = true;
    searchEventsSpinner.setAttribute('hidden', '');

    if (this.status !== 200) {
        searchEventsError.innerHTML = this.responseText;
        return;
    }

    document.getElementById('searchResults').innerHTML = this.responseText;
}

// ----- Suspension API -----

let suspendUserForm = document.getElementById('suspendUserForm');
if (suspendUserForm != null) {
    suspendUserForm.addEventListener('submit', sendSuspendUserRequest);
}

function sendSuspendUserRequest(event) {
    event.preventDefault();

    let duration = this.querySelector('input[name=duration]').value;
    let reason = this.querySelector('input[name=reason]').value;

    let data = {
        duration: duration,
        reason: reason,
    };

    sendAjaxRequest(this.method, this.action, data, suspendUserHandler);
}

function suspendUserHandler() {
    if (this.status !== 200) {
        document.getElementById('suspendUserError').innerHTML = this.responseText;
        return;
    }

    document.querySelector('#suspendUserModal .btn-close').click();

    document.getElementById('suspensionBanStatus').outerHTML = this.responseText;
    document.getElementById('suspendUserButton').remove();

    // Remove the modal after a timeout so that the closing animation can finish
    setTimeout(() => {
        document.getElementById('suspendUserModal').remove();
    }, 1000);
}

// ----- Ban API -----

let banUserForm = document.getElementById('banUserForm');
if (banUserForm != null) {
    banUserForm.addEventListener('submit', sendBanUserRequest);
}

function sendBanUserRequest(event) {
    event.preventDefault();

    let reason = this.querySelector('input[name=reason]').value;

    let data = {
        reason: reason,
    };
    
    sendAjaxRequest(this.method, this.action, data, banUserHandler);
}

function banUserHandler() {
    if (this.status !== 200) {
        document.getElementById('banUserError').innerHTML = this.responseText;
        return;
    }

    document.querySelector('#banUserModal .btn-close').click();

    document.getElementById('suspensionBanStatus').outerHTML = this.responseText;
    document.getElementById('banUserButton').remove();

    let suspendUserButton = document.getElementById('suspendUserButton');
    let suspendUserModal = document.getElementById('suspendUserModal');

    if (suspendUserButton != null) {
        suspendUserButton.remove();
    }

    if (suspendUserModal != null) {
        suspendUserModal.remove();
    }

    // Remove the ban user modal after a timeout so that the closing animation can finish
    setTimeout(() => {
        document.getElementById('banUserModal').remove();
    }, 1000);
}

// ----- Match Results API -----

let leaderboardSettingsForm = document.getElementById('leaderboardSettingsForm');
if (leaderboardSettingsForm !== null) {
    leaderboardSettingsForm.addEventListener('submit', sendUpdateLeaderboardSettingsRequest);
}

function sendUpdateLeaderboardSettingsRequest(event) {
    event.preventDefault();

    let method = this.querySelector('input[name=_method]').value;
    let winPoints = this.querySelector('input[name=winPoints]').value;
    let drawPoints = this.querySelector('input[name=drawPoints]').value;
    let lossPoints = this.querySelector('input[name=lossPoints]').value;
    let generateLeaderboard = this.querySelector('input[name=generateLeaderboard]').checked;

    let data = {
        winPoints: winPoints,
        drawPoints: drawPoints,
        lossPoints: lossPoints,
        generateLeaderboard: generateLeaderboard,
    };

    console.log(data);

    sendAjaxRequest(method, this.action, data, updateLeaderboardSettingsHandler);
}

function updateLeaderboardSettingsHandler() {
    if (this.status !== 200) {
        document.getElementById('leaderboardSettingsError').innerHTML = this.responseText;
        return;
    }

    document.getElementById('leaderboard').innerHTML = this.responseText;
}

let createMatchForm = document.getElementById('createMatchForm');
if (createMatchForm !== null) {
    let firstSelect = createMatchForm.querySelector('select[name=first]');
    firstSelect.addEventListener('change', function() {
        disableSameCompetitor(firstSelect.value);
    });
    disableSameCompetitor(firstSelect.value);
}

function disableSameCompetitor(id) {
    let secondSelect = createMatchForm.querySelector('select[name=second]');
    let sameOption = secondSelect.querySelector('option[value=\'' + id + '\']');
    
    for (let option of secondSelect.querySelectorAll('option')) {
        option.disabled = false;
    }

    sameOption.disabled = true;
    sameOption.selected = false;
}

// ----- Competitors API -----

let addCompetitorForm = document.getElementById('addCompetitorForm');
if (addCompetitorForm !== null) {
    addCompetitorForm.addEventListener('submit', sendCreateCompetitorRequest);
}

function sendCreateCompetitorRequest(event) {
    event.preventDefault();

    let name = this.querySelector('input[name=name]').value;

    let data = {
        name: name
    };

    sendAjaxRequest(this.method, this.action, data, createCompetitorHandler);
}

function createCompetitorHandler() {
    let addCompetitorError = document.getElementById('addCompetitorError');

    if (this.status !== 200) {
        addCompetitorError.innerHTML = this.responseText;
        return;
    }

    addCompetitorError.innerHTML = '';
    document.querySelector('#addCompetitorForm input[name=name]').value = '';
    document.getElementById('competitors').insertAdjacentHTML('beforeend', this.responseText);
}
