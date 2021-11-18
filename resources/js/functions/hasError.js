export default (handle, errors) => {
    if (!errors) {
        return;
    }
    let hasError = Object.keys(errors).includes(handle);


    if (hasError) {
        if (Array.isArray(errors[handle])) {
            return errors[handle][0]
        }
        return errors[handle]
    }
};
