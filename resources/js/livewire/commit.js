/**
 * Temporary fix for Livewire. Livewire doesn't allow to order dispatches, so if
 * Livewire dispatches an event to window/document, all listeners will perform BEFORE
 * Livewire rendered the component.
 *
 * If listeners modify something in the document, it can lead to strange situations.
 */
class Commit {
    constructor(responded) {
        this.responded = responded;
    }

    waitForRespond() {
        return new Promise((resolve) => {
            const checkRespond = () => {
                if (this.responded === true) {
                    resolve();
                } else {
                    setTimeout(checkRespond, 100);
                }
            };

            checkRespond();
        });
    }
}

const commit = new Commit(false);

export { commit as Commit };
