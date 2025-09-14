import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["wrapper", "content", "date"];

    static values = {
        fromId: Number,
    };

    connect() {
        let currentUser = parseInt(document.getElementById("current-user").dataset.id);
        let fromSelf = currentUser === this.fromIdValue;
        console.log(fromSelf)
        if (fromSelf) {
            this.wrapperTarget.classList.add('flex-row-reverse', 'justify-content-start');
        } else {
            this.wrapperTarget.classList.add('justify-content-start');
        }
        this.contentTarget.classList.add(fromSelf ? 'bg-info-subtle' : 'bg-danger-subtle');
        this.dateTarget.classList.add(fromSelf ? 'text-end' : 'text-start');
    }
}
