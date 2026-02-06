type Access = "Public" | "Private"

export interface Project {
  id: number;
  title: string;
  client: string;
  tracked: boolean;
  progress: number;
  access: Access;
};
