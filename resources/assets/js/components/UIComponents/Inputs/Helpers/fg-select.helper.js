export default {
  mapToSelectListItem(collection, keys = []) {
    return (collection || []).map((obj = { ...keys }) => ({
      id: obj[keys[0]],
      label: obj[keys[1]]
    }));
  }
};
