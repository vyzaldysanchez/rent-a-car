import fgInput from './components/UIComponents/Inputs/formGroupInput.vue';
import fgSelect from './components/UIComponents/Inputs/formGroupSelect.vue';
import fgCheck from './components/UIComponents/Inputs/formGroupCheck.vue';
import DropDown from './components/UIComponents/Dropdown.vue';

/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */

const GlobalComponents = {
  install(Vue) {
    Vue.component('FgInput', fgInput);
    Vue.component('FgSelect', fgSelect);
    Vue.component('FgCheck', fgCheck);
    Vue.component('DropDown', DropDown);
  }
};

export default GlobalComponents;
