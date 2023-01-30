import { format } from "date-fns";

export const columns = [
  {
    Header: "#",
    Footer: "#",
    accessor: "id",
    sticky: "left"
  },
  {
    Header: "Date",
    Footer: "Date",
    accessor: "date",
    sticky: "left",
    sortType: 'basic'
  },
  {
    Header: "Job Title",
    Footer: "Job Title",
    accessor: "job_title",
    sticky: "left",
    sortType: 'basic'
  },
  {
    Header: "Company",
    Footer: "Company",
    accessor: "company",
    sticky: "left",
    sortType: 'basic'
  },
  {
    Header: "Website",
    Footer: "Website",
    accessor: "website",
    sticky: "left"
  },
  {
    Header: "Industry",
    Footer: "Industry",
    accessor: "industry",
    sticky: "left"
  },
  {
    Header: "Salary",
    Footer: "Salary",
    accessor: "salary",
    sticky: "left"
  },
  {
    Header: "Level",
    Footer: "Level",
    accessor: "level",
    sticky: "left"
  },
  {
    Header: "Remote",
    Footer: "Remote",
    accessor: "remote",
    sticky: "left"
  },
  {
    Header: "Area",
    Footer: "Area",
    accessor: "area",
    sticky: "left"
  },
  {
    Header: "City",
    Footer: "City",
    accessor: "city",
    sticky: "left",
    sortType: 'basic'
  },
  {
    Header: "State",
    Footer: "State",
    accessor: "state",
    sticky: "left"
  },
  {
    Header: "Zip Code",
    Footer: "Zip Code",
    accessor: "zipcode",
    sticky: "left"
  },
];
