import LoadingMessage from './LoadingMessage.vue';

const LoadingMessagePlugin = {
  install(Vue) {
    Vue.component('LoadingMessage', LoadingMessage);
  }
};

export default LoadingMessagePlugin;
