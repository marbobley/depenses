import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="closeable" attribute will cause
 * this controller to be executed. The name "closeable" comes from the filename:
 * closeable_controller.js -> "closeable"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    close(){
        this.element.remove();
    }
}
