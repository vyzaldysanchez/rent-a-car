export default {
  mapToSelectListItem(collection, keys = []) {
    return (collection || []).map((obj = { ...keys }) => ({
      value: obj[keys[0]],
      label: obj[keys[1]]
    }));
  }
};
