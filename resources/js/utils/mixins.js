let fullName = {
    methods: {
        getFullName: function (arr) {
            if(!(arr.lastname || arr.firstname  || arr.patronymic)) {
                return 'User not registered';
            }
            return arr.lastname + ' ' + arr.firstname + ' ' + arr.patronymic;
        }
    }
};
export { fullName };
